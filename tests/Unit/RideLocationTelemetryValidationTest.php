<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CaptainRideController;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RideLocationTelemetryValidationTest extends TestCase
{
    public function test_valid_optional_telemetry_is_accepted(): void
    {
        $validator = Validator::make([
            'latitude' => 31.4504,
            'longitude' => 73.1350,
            'heading' => 359.99,
            'speed_mps' => 100,
            'accuracy_meters' => 1000,
        ], CaptainRideController::LOCATION_RULES);

        self::assertFalse($validator->fails());
    }

    #[DataProvider('invalidTelemetryProvider')]
    public function test_out_of_range_telemetry_is_rejected(string $field, float $value): void
    {
        $validator = Validator::make([
            'latitude' => 31.4504,
            'longitude' => 73.1350,
            $field => $value,
        ], CaptainRideController::LOCATION_RULES);

        self::assertTrue($validator->fails());
        self::assertArrayHasKey($field, $validator->errors()->toArray());
    }

    public static function invalidTelemetryProvider(): array
    {
        return [
            'heading below zero' => ['heading', -0.01],
            'heading at 360' => ['heading', 360],
            'speed below zero' => ['speed_mps', -0.01],
            'speed above maximum' => ['speed_mps', 100.01],
            'accuracy below zero' => ['accuracy_meters', -0.01],
            'accuracy above maximum' => ['accuracy_meters', 1000.01],
        ];
    }
}
