<?php

return [
    'onboarding_services' => [
        [
            'id' => 'account-onboarding',
            'description' => 'Partner account onboarding',
            'default_unit_price' => 5000,
            'default_selected' => true,
        ],
        [
            'id' => 'profile-menu',
            'description' => 'Store profile and menu configuration',
            'default_unit_price' => 8000,
            'default_selected' => true,
        ],
        [
            'id' => 'zone-support',
            'description' => 'Delivery zone setup and initial technical support',
            'default_unit_price' => 5000,
            'default_selected' => true,
        ],
        [
            'id' => 'photography',
            'description' => 'Product photography',
            'default_unit_price' => 6000,
            'default_selected' => false,
        ],
        [
            'id' => 'staff-training',
            'description' => 'Staff training',
            'default_unit_price' => 3500,
            'default_selected' => false,
        ],
    ],
    'delivery_time_options' => [
        ['value' => 'min', 'label' => 'minutes'],
        ['value' => 'hours', 'label' => 'hours'],
        ['value' => 'days', 'label' => 'days'],
    ],
    'validation' => [
        'invoice_due_days' => 7,
        'minimum_delivery_value' => 1,
        'maximum_delivery_value' => 999,
        'invoice_note_max_length' => 2000,
        'draft_max_age_days' => 30,
    ],
    'reminder_cooldown_minutes' => 5,
    'finance' => [
        'release_policy' => 'approved',
        'minimum_withdrawal_amount' => env('OPS_MINIMUM_WITHDRAWAL_AMOUNT', 1),
        'maximum_withdrawal_amount' => env('OPS_MAXIMUM_WITHDRAWAL_AMOUNT', 0),
    ],
    'checkout' => [
        'token_lifetime_days' => env('OPS_INVOICE_CHECKOUT_LIFETIME_DAYS', 30),
        'attempt_lifetime_minutes' => env('OPS_INVOICE_PAYMENT_ATTEMPT_MINUTES', 20),
    ],
    'approval' => [
        'password_setup_lifetime_minutes' => env('OPS_VENDOR_PASSWORD_SETUP_MINUTES', 1440),
        'email_subject' => 'Your Zaqoota partner account is approved',
        'email_body' => 'Your restaurant account is approved. Set your password using the secure one-time link below.',
    ],
    'media' => [
        'disk' => env('OPS_ONBOARDING_MEDIA_DISK', 'local'),
        'maximum_size_kb' => 2048,
        'maximum_image_pixels' => 40000000,
        'maximum_menu_photos' => 8,
        'preview_minutes' => 60,
        'orphan_after_hours' => 720,
    ],
    'email_templates' => [
        'invoice' => [
            'subject' => 'Invoice #{invoiceNumber} - Zaqoota',
            'heading' => 'Your onboarding invoice is ready',
            'body' => 'Please find your Zaqoota onboarding invoice attached to this email.',
        ],
        'reminder' => [
            'subject' => 'Payment reminder for invoice #{invoiceNumber} - Zaqoota',
            'heading' => 'Payment reminder',
            'body' => 'This is a friendly reminder that your attached onboarding invoice remains unpaid.',
        ],
        'paid' => [
            'subject' => 'Payment received for invoice #{invoiceNumber} - Zaqoota',
            'heading' => 'Payment received',
            'body' => 'Thank you. Your paid onboarding invoice is attached for your records.',
        ],
    ],
];
