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

        $now = now();
        $footer = 'Need help? The Zaqoota support team is always here for you.';
        $copyright = 'Copyright 2026 Zaqoota. All rights reserved.';

        DB::table('email_templates')
            ->where('type', 'store')
            ->where('email_type', 'registration')
            ->update([
                'title' => 'Welcome to Zaqoota, {storeName}',
                'body' => '<p>Dear {storeName} team,</p><p>Thank you for applying to become a Zaqoota restaurant partner. We received your application and our team will review it shortly.</p><p>We will email you as soon as your application status changes.</p>',
                'body_2' => null,
                'footer_text' => $footer,
                'copyright_text' => $copyright,
                'email_template' => '12',
                'updated_at' => $now,
            ]);

        DB::table('email_templates')
            ->where('type', 'store')
            ->where('email_type', 'approve')
            ->update([
                'title' => '{storeName} is approved on Zaqoota',
                'body' => '<p>Dear {storeName} team,</p><p>Your partner application has been approved. You can now sign in, complete your restaurant setup, publish your menu, and start receiving Zaqoota orders.</p><p>Welcome aboard.</p>',
                'body_2' => null,
                'button_name' => 'Sign in to Partner Panel',
                'button_url' => 'https://zaqoota.com/login/vendor',
                'button_enabled' => true,
                'footer_text' => $footer,
                'copyright_text' => $copyright,
                'email_template' => '12',
                'updated_at' => $now,
            ]);

        if (Schema::hasTable('translations')) {
            $templateIds = DB::table('email_templates')
                ->where('type', 'store')
                ->whereIn('email_type', ['registration', 'approve'])
                ->pluck('id');

            DB::table('translations')
                ->where('translationable_type', 'App\\Models\\EmailTemplate')
                ->whereIn('translationable_id', $templateIds)
                ->whereIn('key', ['title', 'body', 'body_2', 'footer_text', 'copyright_text', 'button_name'])
                ->where(function ($query) {
                    $query->where('value', 'like', '%6ammart%')
                        ->orWhere('value', 'like', '%First%log in to your store panel%')
                        ->orWhere('value', 'like', '%set up your store and start selling%');
                })
                ->delete();
        }
    }

    public function down(): void
    {
        // Preserve email copy edited later through the Admin panel.
    }
};
