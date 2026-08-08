<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('email_templates')) {
            return;
        }

        $templates = [
            'admin' => [
                'forget_password' => ['Zaqoota password reset request', '<p>Hello {userName},</p><p>We received a request to reset your Zaqoota admin password. Use the verification code below to continue. If you did not request this, please secure your account and contact Zaqoota support.</p>'],
                'store_registration' => ['New Zaqoota partner application: {storeName}', '<p>A new restaurant partner has applied to join Zaqoota.</p><p><strong>Store:</strong> {storeName}</p><p>Please review the application in Store Management and approve or reject it after verifying the submitted details.</p>'],
                'dm_registration' => ['New Zaqoota rider application: {deliveryManName}', '<p>A new delivery partner has applied to join Zaqoota.</p><p><strong>Delivery partner:</strong> {deliveryManName}</p><p>Please review the application in Deliveryman Management and verify the submitted details.</p>'],
                'withdraw_request' => ['Withdrawal request from {storeName}', '<p>{storeName} submitted a new withdrawal request.</p><p><strong>Transaction:</strong> {transactionId}</p><p>Please review the request and payment details in the Zaqoota admin panel.</p>'],
                'campaign_request' => ['Campaign request from {storeName}', '<p>{storeName} has requested to join a Zaqoota campaign.</p><p>Please review the request in Campaign Management and update the partner when a decision is made.</p>'],
                'refund_request' => ['Refund request for order #{orderId}', '<p>A refund request has been submitted on Zaqoota.</p><p><strong>Customer:</strong> {userName}<br><strong>Order:</strong> #{orderId}</p><p>Please review the order and refund reason before taking action.</p>'],
                'login' => ['New Zaqoota admin sign-in', '<p>A new sign-in to the Zaqoota admin panel was detected.</p><p>If this activity was not expected, please change the account password immediately.</p>'],
                'dm_withdraw_request' => ['Rider withdrawal request: {deliveryManName}', '<p>{deliveryManName} submitted a new withdrawal request.</p><p><strong>Transaction:</strong> {transactionId}</p><p>Please review the request and rider balance in the Zaqoota admin panel.</p>'],
                'new_advertisement' => ['New advertisement request from {storeName}', '<p>{storeName} submitted a new advertisement request.</p><p><strong>Advertisement:</strong> {advertisementId}</p><p>Please review its content, schedule, and placement in the Zaqoota admin panel.</p>'],
                'update_advertisement' => ['Advertisement update from {storeName}', '<p>{storeName} updated an advertisement request.</p><p><strong>Advertisement:</strong> {advertisementId}</p><p>Please review the latest content and settings before approval.</p>'],
            ],
            'store' => [
                'registration' => ['Welcome to Zaqoota, {storeName}', '<p>Dear {storeName} team,</p><p>Thank you for applying to become a Zaqoota restaurant partner. We received your application and our team will review it shortly.</p><p>We will email you as soon as your application status changes.</p>'],
                'approve' => ['{storeName} is approved on Zaqoota', '<p>Dear {storeName} team,</p><p>Your partner application has been approved. You can now sign in, complete your restaurant setup, publish your menu, and start receiving Zaqoota orders.</p><p>Welcome aboard.</p>'],
                'deny' => ['Update on your Zaqoota application, {storeName}', '<p>Dear {storeName} team,</p><p>We are unable to approve your partner application at this time.</p><p>Please contact Zaqoota support if you need more information or want help correcting your application.</p>'],
                'withdraw_approve' => ['Withdrawal approved for {storeName}', '<p>Dear {storeName} team,</p><p>Your withdrawal request has been approved and is being processed using your registered payment details.</p><p>You can review the transaction in your Zaqoota partner panel.</p>'],
                'withdraw_deny' => ['Withdrawal request declined for {storeName}', '<p>Dear {storeName} team,</p><p>Your withdrawal request could not be approved.</p><p>Please review your transaction details or contact Zaqoota support for assistance.</p>'],
                'campaign_request' => ['Campaign request received for {storeName}', '<p>Dear {storeName} team,</p><p>We received your request to join a Zaqoota campaign. Our team will review it and notify you when a decision is available.</p>'],
                'campaign_approve' => ['Campaign request approved for {storeName}', '<p>Dear {storeName} team,</p><p>Your request to join the Zaqoota campaign has been approved. The campaign will appear in your partner panel according to its active schedule.</p>'],
                'campaign_deny' => ['Campaign request update for {storeName}', '<p>Dear {storeName} team,</p><p>Your request to join the selected Zaqoota campaign was not approved.</p><p>Please review other available campaigns or contact support if you have questions.</p>'],
                'suspend' => ['Your Zaqoota partner account is suspended, {storeName}', '<p>Dear {storeName} team,</p><p>Your Zaqoota partner account has been suspended and cannot currently receive orders.</p><p>Please contact Zaqoota support for details and next steps.</p>'],
                'unsuspend' => ['Your Zaqoota partner account is active again, {storeName}', '<p>Dear {storeName} team,</p><p>Your partner account has been restored. You can sign in and resume managing orders on Zaqoota.</p>'],
                'product_approved' => ['Your item was approved on Zaqoota, {storeName}', '<p>Dear {storeName} team,</p><p>Your submitted item has been approved and can now be offered to customers according to its availability settings.</p>'],
                'product_deny' => ['Item review update for {storeName}', '<p>Dear {storeName} team,</p><p>Your submitted item was not approved for publication on Zaqoota.</p><p>Please review the item details and contact support if you need clarification.</p>'],
                'subscription-successful' => ['Zaqoota subscription activated for {storeName}', '<p>Dear {storeName} team,</p><p>Your Zaqoota business subscription is active. Your plan benefits are now available in the partner panel.</p>'],
                'subscription-renew' => ['Zaqoota subscription renewed for {storeName}', '<p>Dear {storeName} team,</p><p>Your Zaqoota business subscription has been renewed successfully. Thank you for continuing your partnership with us.</p>'],
                'subscription-shift' => ['Zaqoota subscription changed for {storeName}', '<p>Dear {storeName} team,</p><p>Your Zaqoota business subscription has been changed successfully. The updated plan and benefits are available in your partner panel.</p>'],
                'subscription-cancel' => ['Zaqoota subscription cancelled for {storeName}', '<p>Dear {storeName} team,</p><p>Your Zaqoota business subscription has been cancelled. Please review your business plan settings if you want to reactivate a plan.</p>'],
                'subscription-deadline' => ['Zaqoota subscription ending soon for {storeName}', '<p>Dear {storeName} team,</p><p>Your Zaqoota business subscription is approaching its renewal date.</p><p>Please review your plan to avoid interruption to subscription features.</p>'],
                'subscription-plan_upadte' => ['Zaqoota subscription plan updated for {storeName}', '<p>Dear {storeName} team,</p><p>The details of your Zaqoota subscription plan have been updated. Please review the current benefits and terms in your partner panel.</p>'],
                'advertisement_pause' => ['Your Zaqoota advertisement is paused, {storeName}', '<p>Dear {storeName} team,</p><p>Your advertisement is currently paused and is not being shown to customers.</p><p>Review its status in the partner panel or contact support for help.</p>'],
                'advertisement_approved' => ['Your Zaqoota advertisement is approved, {storeName}', '<p>Dear {storeName} team,</p><p>Your advertisement has been approved and will run according to its configured schedule.</p>'],
                'advertisement_create' => ['Advertisement request received for {storeName}', '<p>Dear {storeName} team,</p><p>We received your advertisement request and will notify you after it has been reviewed.</p>'],
                'advertisement_deny' => ['Advertisement review update for {storeName}', '<p>Dear {storeName} team,</p><p>Your advertisement request was not approved.</p><p>Please review the content and requirements or contact Zaqoota support for assistance.</p>'],
                'advertisement_resume' => ['Your Zaqoota advertisement has resumed, {storeName}', '<p>Dear {storeName} team,</p><p>Your advertisement is active again and will be shown according to its configured schedule.</p>'],
            ],
            'dm' => [
                'registration' => ['Welcome to Zaqoota, {deliveryManName}', '<p>Dear {deliveryManName},</p><p>We received your application to become a Zaqoota delivery partner. Our team will review your information and notify you when your status changes.</p>'],
                'approve' => ['Your Zaqoota rider account is approved, {deliveryManName}', '<p>Dear {deliveryManName},</p><p>Your delivery partner account has been approved. You can now sign in to the Zaqoota Rider app, complete your availability settings, and start accepting deliveries.</p>'],
                'deny' => ['Update on your Zaqoota rider application, {deliveryManName}', '<p>Dear {deliveryManName},</p><p>We are unable to approve your delivery partner application at this time.</p><p>Please contact Zaqoota support if you need clarification or want to update your details.</p>'],
                'suspend' => ['Your Zaqoota rider account is suspended, {deliveryManName}', '<p>Dear {deliveryManName},</p><p>Your Zaqoota delivery partner account has been suspended and cannot currently accept deliveries.</p><p>Please contact support for details and next steps.</p>'],
                'cash_collect' => ['Cash collection recorded for {deliveryManName}', '<p>Dear {deliveryManName},</p><p>Your cash handover has been recorded successfully.</p><p><strong>Transaction:</strong> {transactionId}</p><p>You can review the updated balance in the Zaqoota Rider app.</p>'],
                'forget_password' => ['Reset your Zaqoota Rider password', '<p>Hello {userName},</p><p>Use the verification code below to reset your Zaqoota Rider password. Do not share this code with anyone.</p>'],
                'withdraw_approve' => ['Rider withdrawal approved for {deliveryManName}', '<p>Dear {deliveryManName},</p><p>Your withdrawal request has been approved and is being processed using your registered payment details.</p>'],
                'withdraw_deny' => ['Rider withdrawal request declined for {deliveryManName}', '<p>Dear {deliveryManName},</p><p>Your withdrawal request could not be approved.</p><p>Please review your details or contact Zaqoota support for assistance.</p>'],
                'unsuspend' => ['Your Zaqoota Rider account is active again, {deliveryManName}', '<p>Dear {deliveryManName},</p><p>Your delivery partner account has been restored. You can sign in and resume accepting deliveries.</p>'],
            ],
            'user' => [
                'registration' => ['Welcome to Zaqoota, {userName}', '<p>Hi {userName},</p><p>Your Zaqoota account has been created successfully. You can now discover restaurants, place orders, and track deliveries from the Zaqoota app.</p>'],
                'registration_otp' => ['Verify your Zaqoota account, {userName}', '<p>Hi {userName},</p><p>Use the verification code below to complete your Zaqoota registration. Do not share this code with anyone.</p>'],
                'login_otp' => ['Your Zaqoota login code', '<p>Hi {userName},</p><p>Use the verification code below to sign in to your Zaqoota account. If you did not request this code, you can safely ignore this email.</p>'],
                'order_verification' => ['Delivery verification code for your Zaqoota order', '<p>Hi {userName},</p><p>Share the verification code below with your Zaqoota delivery partner only when your order arrives.</p>'],
                'new_order' => ['Zaqoota order #{orderId} confirmed', '<p>Hi {userName},</p><p>Your order <strong>#{orderId}</strong> from <strong>{storeName}</strong> has been confirmed.</p><p>We will keep you updated while the restaurant prepares it and your delivery partner brings it to you.</p>'],
                'refund_order' => ['Refund completed for Zaqoota order #{orderId}', '<p>Hi {userName},</p><p>Your refund for order <strong>#{orderId}</strong> has been processed.</p><p>The time needed for the amount to appear depends on your original payment method.</p>'],
                'forget_password' => ['Reset your Zaqoota password', '<p>Hi {userName},</p><p>Use the verification code below to reset your Zaqoota password. Do not share this code with anyone.</p>'],
                'refund_request_deny' => ['Refund request update for order #{orderId}', '<p>Hi {userName},</p><p>Your refund request for order <strong>#{orderId}</strong> was not approved.</p><p>Please contact Zaqoota support if you need more information about this decision.</p>'],
                'add_fund' => ['Funds added to your Zaqoota wallet', '<p>Hi {userName},</p><p>Funds have been added to your Zaqoota wallet successfully.</p><p><strong>Transaction:</strong> {transactionId}</p><p>Your updated balance is available in the Zaqoota app.</p>'],
                'pos_registration' => ['Your Zaqoota account is ready, {userName}', '<p>Hi {userName},</p><p>Your Zaqoota customer account has been created successfully. Your login details are shown securely below.</p><p>Please change the temporary password after your first sign-in.</p>'],
                'suspend' => ['Your Zaqoota account is suspended, {userName}', '<p>Hi {userName},</p><p>Your Zaqoota account has been suspended and cannot currently place orders.</p><p>Please contact Zaqoota support for details and next steps.</p>'],
                'unsuspend' => ['Your Zaqoota account is active again, {userName}', '<p>Hi {userName},</p><p>Your Zaqoota account has been restored. You can sign in and continue ordering.</p>'],
                'offline_payment_approve' => ['Offline payment approved for your Zaqoota order', '<p>Your offline payment has been verified and approved.</p><p>Your order will continue through the normal preparation and delivery process.</p>'],
                'offline_payment_deny' => ['Offline payment could not be approved', '<p>We could not verify the offline payment submitted for your Zaqoota order.</p><p>Please review the payment details or contact Zaqoota support for assistance.</p>'],
            ],
        ];

        $footer = 'Need help? The Zaqoota support team is always here for you.';
        $copyright = 'Copyright 2026 Zaqoota. All rights reserved.';

        foreach ($templates as $type => $typeTemplates) {
            foreach ($typeTemplates as $emailType => [$title, $body]) {
                DB::table('email_templates')
                    ->where('type', $type)
                    ->where('email_type', $emailType)
                    ->update([
                        'title' => $title,
                        'body' => $body,
                        'footer_text' => $footer,
                        'copyright_text' => $copyright,
                        'email_template' => '12',
                        'updated_at' => now(),
                    ]);
            }
        }
    }

    public function down(): void
    {
        // Branded email copy may be edited in Admin after deployment; do not overwrite it on rollback.
    }
};
