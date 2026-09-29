<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Services\RidePaymentService;
use ReflectionMethod;
use Tests\TestCase;

class RidePaymentMethodPolicyTest extends TestCase
{
    public function test_payment_attempts_enforce_the_same_admin_options_exposed_to_customer(): void
    {
        $prepareAttempt = $this->methodBody(RidePaymentService::class, 'prepareAttempt');
        $assertMethod = $this->methodBody(RidePaymentService::class, 'assertPaymentMethodEnabled');
        $summary = $this->methodBody(CustomerRideController::class, 'paymentSummaryData');

        self::assertStringContainsString('assertPaymentMethodEnabled($ride, $method, $gateway)', $prepareAttempt);
        self::assertStringContainsString("! \$options['cash_enabled']", $assertMethod);
        self::assertStringContainsString("! \$options['wallet_enabled']", $assertMethod);
        self::assertStringContainsString("! \$options['digital_enabled']", $assertMethod);
        self::assertStringContainsString("\$options['digital_gateways']", $assertMethod);
        self::assertStringContainsString('$this->paymentService->paymentOptions($ride)', $summary);
        self::assertStringContainsString('...$paymentOptions', $summary);
    }

    public function test_partial_payment_rechecks_wallet_and_remainder_method_switches(): void
    {
        $options = $this->methodBody(RidePaymentService::class, 'paymentOptions');
        $partial = $this->methodBody(RidePaymentService::class, 'assertPartialPaymentAllowed');

        self::assertStringContainsString("'wallet_status'", $options);
        self::assertStringContainsString("'partial_payment_status'", $options);
        self::assertStringContainsString("'cash_partial_enabled'", $options);
        self::assertStringContainsString("'digital_partial_enabled'", $options);
        self::assertStringContainsString('self::PREPAYMENT_STATUSES', $options);
        self::assertStringContainsString('RideRequest::STATUS_CANCELLED', $options);
        self::assertStringContainsString("\$options['cash_partial_enabled']", $partial);
        self::assertStringContainsString("\$options['digital_partial_enabled']", $partial);
    }

    public function test_only_active_configured_gateways_are_returned(): void
    {
        $gateways = $this->methodBody(RidePaymentService::class, 'enabledDigitalGateways');

        self::assertStringContainsString("where('is_active', 1)", $gateways);
        self::assertStringContainsString("where('settings_type', 'payment_config')", $gateways);
        self::assertStringContainsString("data_get(\$setting->{\$credentials}, 'status', 0)", $gateways);
        self::assertContains('assan_pay', RidePaymentService::DIGITAL_GATEWAYS);
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
