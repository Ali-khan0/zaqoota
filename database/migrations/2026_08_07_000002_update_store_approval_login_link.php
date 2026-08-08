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

        DB::table('email_templates')
            ->where('type', 'store')
            ->where('email_type', 'approve')
            ->update([
                'body' => '<p>Dear {storeName} team,</p><p>Your partner application has been approved. You can now sign in, complete your restaurant setup, publish your menu, and start receiving Zaqoota orders.</p><p>Welcome aboard.</p>',
                'button_name' => 'Sign in to Partner Panel',
                'button_url' => 'https://zaqoota.com/login/vendor',
                'button_enabled' => true,
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Preserve any approval-email edits made later through the Admin panel.
    }
};
