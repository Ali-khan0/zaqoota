<?php

namespace Tests\Unit;

use App\Services\RideCaptainEligibilityService;
use ReflectionMethod;
use Tests\TestCase;

class RideCaptainAssignmentPolicyTest extends TestCase
{
    public function test_assignment_lock_uses_a_database_row_lock(): void
    {
        $method = new ReflectionMethod(RideCaptainEligibilityService::class, 'lockCaptainForAssignment');
        $source = file($method->getFileName());
        $body = implode('', array_slice(
            $source,
            $method->getStartLine() - 1,
            $method->getEndLine() - $method->getStartLine() + 1,
        ));

        self::assertStringContainsString('withoutGlobalScopes()', $body);
        self::assertStringContainsString('whereKey($captainId)', $body);
        self::assertStringContainsString('lockForUpdate()', $body);
    }

    public function test_customer_and_admin_assignment_share_the_lock_boundary(): void
    {
        $root = dirname(__DIR__, 2);
        $customer = file_get_contents($root.'/app/Http/Controllers/Api/V1/CustomerRideController.php');
        $admin = file_get_contents($root.'/app/Http/Controllers/Admin/RideHailing/RideOperationController.php');

        self::assertStringContainsString('lockCaptainForAssignment((int) $offer->delivery_man_id)', $customer);
        self::assertStringContainsString("lockCaptainForAssignment((int) \$validated['delivery_man_id'])", $admin);
    }
}
