<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Models\DeliveryMan;
use App\Models\RideOffer;
use App\Models\RideRating;
use App\Models\RideRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use ReflectionClass;
use ReflectionMethod;
use Tests\TestCase;

class RideCustomerResponseTest extends TestCase
{
    public function test_assigned_ride_contains_route_accepted_pickup_and_enriched_captain(): void
    {
        $ride = $this->baseRide();
        $ride->route_polyline = 'stored-polyline';

        $rating = (object) ['average' => 4.8, 'rating_count' => 91];
        $captain = new DeliveryMan;
        $captain->setRawAttributes([
            'id' => 14,
            'f_name' => 'Sample',
            'l_name' => 'Captain',
            'phone' => '+00000000000',
            'image' => null,
        ]);
        $captain->setRelation('rating', new Collection([$rating]));
        $captain->setRelation('rideRating', new Collection([(object) ['average' => 5.0, 'rating_count' => 9]]));

        $offer = new RideOffer;
        $offer->setRawAttributes([
            'pickup_distance_meters' => 2400,
            'pickup_eta_seconds' => 420,
        ]);
        $offer->created_at = Carbon::parse('2026-08-15T12:05:00+05:00');

        $ride->setRelation('deliveryMan', $captain);
        $ride->setRelation('acceptedOffer', $offer);

        $response = $this->rideData($ride);

        self::assertSame('stored-polyline', $response['route_polyline']);
        self::assertSame(2400, $response['accepted_pickup']['distance_meters']);
        self::assertSame(420, $response['accepted_pickup']['eta_seconds']);
        self::assertSame('Sample Captain', $response['captain']['name']);
        self::assertSame('', $response['captain']['image_url']);
        self::assertSame(4.82, $response['captain']['rating']);
        self::assertSame(100, $response['captain']['rating_count']);
    }

    public function test_pre_assignment_and_legacy_ride_use_safe_fallbacks(): void
    {
        $ride = $this->baseRide();
        $ride->route_polyline = null;
        $ride->setRelation('deliveryMan', null);
        $ride->setRelation('acceptedOffer', null);

        $response = $this->rideData($ride);

        self::assertSame('', $response['route_polyline']);
        self::assertNull($response['accepted_pickup']);
        self::assertNull($response['captain']);
        self::assertNull($response['vehicle']);
    }

    public function test_customer_rating_is_returned_only_from_the_ride_relation(): void
    {
        $ride = $this->baseRide();
        $rating = new RideRating;
        $rating->setRawAttributes([
            'ride_request_id' => 42,
            'delivery_man_id' => 14,
            'rating' => 5,
            'comment' => 'Safe and professional',
            'updated_at' => '2026-08-15 12:30:00',
        ]);
        $ride->setRelation('customerRating', $rating);
        $ride->setRelation('deliveryMan', null);
        $ride->setRelation('acceptedOffer', null);

        $response = $this->rideData($ride);

        self::assertSame(42, $response['customer_rating']['ride_id']);
        self::assertSame(14, $response['customer_rating']['captain_id']);
        self::assertSame(5, $response['customer_rating']['rating']);
        self::assertSame('Safe and professional', $response['customer_rating']['comment']);
    }

    private function baseRide(): RideRequest
    {
        $ride = new RideRequest;
        $ride->setRawAttributes([
            'id' => 42,
            'request_number' => 'ZQR-0000042',
            'status' => RideRequest::STATUS_RIDER_SELECTED,
            'pickup_address' => 'Pickup',
            'pickup_latitude' => 31.4504,
            'pickup_longitude' => 73.1350,
            'destination_address' => 'Destination',
            'destination_latitude' => 31.4187,
            'destination_longitude' => 73.0791,
        ]);
        $ride->setRelation('category', null);
        $ride->setRelation('rideVehicle', null);
        $ride->setRelation('customerRating', null);

        return $ride;
    }

    private function rideData(RideRequest $ride): array
    {
        $controller = (new ReflectionClass(CustomerRideController::class))->newInstanceWithoutConstructor();
        $method = new ReflectionMethod(CustomerRideController::class, 'rideData');

        return $method->invoke($controller, $ride);
    }
}
