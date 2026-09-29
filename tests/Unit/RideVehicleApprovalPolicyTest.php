<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\DeliveryMan\DeliveryManController;
use App\Http\Controllers\Admin\RideHailing\RideHailingController;
use App\Http\Controllers\Api\V1\DeliverymanController as ApiDeliverymanController;
use App\Services\RideVehicleRegistrationService;
use ReflectionMethod;
use Tests\TestCase;

class RideVehicleApprovalPolicyTest extends TestCase
{
    public function test_users_routes_are_canonical_while_old_ride_routes_remain_available(): void
    {
        $routes = file_get_contents(base_path('routes/admin/routes.php'));
        $usersSidebar = file_get_contents(resource_path('views/layouts/admin/partials/_sidebar_users.blade.php'));
        $rideSidebar = file_get_contents(resource_path('views/layouts/admin/partials/_sidebar_ride_hailing.blade.php'));

        self::assertStringContainsString("['prefix' => 'ride-vehicles', 'as' => 'ride-vehicles.']", $routes);
        self::assertStringContainsString("Route::get('vehicles', [RideHailingController::class, 'vehicles'])->name('vehicles.index')", $routes);
        self::assertStringContainsString("Route::get('vehicles/{vehicle}', [RideHailingController::class, 'showVehicle'])->name('vehicles.show')", $routes);
        self::assertStringContainsString("admin.users.delivery-man.ride-vehicles.index", $usersSidebar);
        self::assertStringContainsString("where('status', 'pending')", $usersSidebar);
        self::assertStringNotContainsString("admin.ride-hailing.vehicles.index", $rideSidebar);
    }

    public function test_review_is_locked_audited_and_rejection_requires_a_note(): void
    {
        $review = $this->methodBody(RideHailingController::class, 'reviewVehicle');
        $update = $this->methodBody(RideHailingController::class, 'updateVehicleReview');
        $audit = $this->methodBody(RideHailingController::class, 'recordVehicleReview');

        self::assertStringContainsString("Rule::in(['approved', 'rejected'])", $review);
        self::assertStringContainsString("Rule::requiredIf(\$request->input('decision') === 'rejected')", $review);
        self::assertStringContainsString('DB::transaction', $update);
        self::assertStringContainsString('lockForUpdate()', $update);
        self::assertStringContainsString("if (\$status !== 'approved')", $update);
        self::assertStringContainsString('$vehicle->is_active = false', $update);
        self::assertStringContainsString('RideVehicleReviewAudit::query()->create', $audit);
        self::assertStringContainsString("'admin_id' => auth('admin')->id()", $audit);

        $store = $this->methodBody(RideHailingController::class, 'storeVehicle');
        $activate = $this->methodBody(RideHailingController::class, 'activateVehicle');
        self::assertStringContainsString("'status' => ['required', Rule::in(['pending'])]", $store);
        self::assertStringContainsString("'is_active' => false", $store);
        self::assertStringContainsString('lockForUpdate()', $activate);
    }

    public function test_list_and_detail_expose_filters_photos_confirmation_and_audit(): void
    {
        $list = file_get_contents(resource_path('views/admin-views/ride-hailing/vehicles/index.blade.php'));
        $detail = file_get_contents(resource_path('views/admin-views/ride-hailing/vehicles/show.blade.php'));
        $migration = file_get_contents(database_path('migrations/2026_09_29_000001_add_review_audit_to_ride_vehicles.php'));

        foreach (['status', 'vehicle_type_id', 'category_id', 'fuel_type'] as $filter) {
            self::assertStringContainsString('name="'.$filter.'"', $list);
        }
        self::assertStringNotContainsString('onchange="this.form.submit()"', $list);
        self::assertStringContainsString('front_image_full_url', $detail);
        self::assertStringContainsString('back_image_full_url', $detail);
        self::assertStringContainsString('reviewAudits', $detail);
        self::assertStringContainsString("name=\"decision\" value=\"approved\"", $detail);
        self::assertStringContainsString("name=\"decision\" value=\"rejected\"", $detail);
        self::assertStringContainsString('return confirm(', $detail);
        self::assertStringContainsString("Schema::create('ride_vehicle_review_audits'", $migration);
        self::assertStringContainsString("foreignId('reviewed_by')", $migration);
        self::assertStringContainsString("timestamp('reviewed_at')", $migration);
    }

    public function test_zone_admin_scope_applies_to_list_detail_decision_and_activation(): void
    {
        $query = $this->methodBody(RideHailingController::class, 'vehicleAdminQuery');

        self::assertStringContainsString("auth('admin')->user()?->zone_id", $query);
        self::assertStringContainsString("whereHas('deliveryMan'", $query);
        foreach (['vehicles', 'showVehicle', 'updateVehicleReview', 'activateVehicle'] as $method) {
            self::assertStringContainsString('$this->vehicleAdminQuery()', $this->methodBody(RideHailingController::class, $method));
        }
    }

    public function test_rider_account_approval_does_not_bypass_vehicle_review(): void
    {
        $approval = $this->methodBody(DeliveryManController::class, 'approveDeliveryManApplication');

        self::assertStringNotContainsString('RideVehicle::query()', $approval);
        self::assertStringNotContainsString("['status' => 'approved', 'is_active' => true]", $approval);
    }

    public function test_rejected_vehicle_can_be_corrected_and_resubmitted_without_using_another_slot(): void
    {
        $routes = file_get_contents(base_path('routes/api/v1/api.php'));
        self::assertStringContainsString("Route::post('ride-vehicles/{vehicle_id}/resubmit'", $routes);

        $controller = $this->methodBody(ApiDeliverymanController::class, 'resubmitRideVehicle');
        self::assertStringContainsString("\$vehicle->status !== 'rejected'", $controller);
        self::assertStringContainsString('resubmissionRules($vehicle)', $controller);
        self::assertStringContainsString('resubmitRejectedVehicle($dm, $vehicle', $controller);

        $service = $this->methodBody(RideVehicleRegistrationService::class, 'resubmitRejectedVehicle');
        self::assertStringContainsString('lockForUpdate()', $service);
        self::assertStringContainsString("'status' => 'pending'", $service);
        self::assertStringContainsString("'is_active' => false", $service);
        self::assertStringContainsString("'from_status' => 'rejected'", $service);
        self::assertStringContainsString("'to_status' => 'pending'", $service);
        self::assertStringContainsString("'admin_id' => null", $service);
        self::assertStringNotContainsString('MAX_PER_RIDER', $service);
    }

    private function methodBody(string $class, string $methodName): string
    {
        $method = new ReflectionMethod($class, $methodName);
        $source = file($method->getFileName());

        return implode('', array_slice(
            $source,
            $method->getStartLine() - 1,
            $method->getEndLine() - $method->getStartLine() + 1,
        ));
    }
}
