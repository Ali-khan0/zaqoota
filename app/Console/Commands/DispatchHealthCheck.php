<?php

namespace App\Console\Commands;

use App\Models\BusinessSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DispatchHealthCheck extends Command
{
    protected $signature = 'dispatch:health';

    protected $description = 'Verify nearest-first dispatch database and queue prerequisites';

    public function handle(): int
    {
        $errors = [];
        $queueConnection = (string) config('queue.default');

        $this->components->twoColumnDetail('Queue connection', $queueConnection ?: '<fg=red>missing</>');
        if ($queueConnection === '' || in_array($queueConnection, ['sync', 'null'], true)) {
            $errors[] = 'QUEUE_CONNECTION must use a durable asynchronous driver such as database or redis.';
        }

        $this->checkTable('jobs', $errors, $queueConnection === 'database');
        $this->checkTable('failed_jobs', $errors, false);
        $this->checkTable('commerce_order_notification_deliveries', $errors, true);
        $this->checkTable('queue_process_statuses', $errors, true);

        if (Schema::hasTable('commerce_order_notification_deliveries')) {
            foreach (['dispatch_wave', 'pickup_distance_meters', 'push_status', 'push_attempts'] as $column) {
                if (! Schema::hasColumn('commerce_order_notification_deliveries', $column)) {
                    $errors[] = "commerce_order_notification_deliveries.{$column} is missing; run migrations.";
                }
            }
        }

        if (Schema::hasTable('business_settings')) {
            $settings = BusinessSetting::query()->whereIn('key', [
                'commerce_dispatch_wave_size',
                'commerce_dispatch_wave_interval_seconds',
                'commerce_dispatch_location_freshness_seconds',
                'commerce_dispatch_maximum_pickup_radius_km',
                'parcel_dispatch_maximum_pickup_radius_km',
                'ride_hailing_dispatch_wave_size',
                'ride_hailing_dispatch_wave_interval_seconds',
                'ride_hailing_dispatch_location_freshness_seconds',
            ])->pluck('value', 'key');

            $this->components->twoColumnDetail('Commerce wave size', (string) ($settings['commerce_dispatch_wave_size'] ?? 3));
            $this->components->twoColumnDetail('Commerce wave interval', ($settings['commerce_dispatch_wave_interval_seconds'] ?? 20).' seconds');
            $this->components->twoColumnDetail('Commerce GPS freshness', ($settings['commerce_dispatch_location_freshness_seconds'] ?? 180).' seconds');
            $this->components->twoColumnDetail('Commerce maximum pickup radius', ($settings['commerce_dispatch_maximum_pickup_radius_km'] ?? 5).' km');
            $this->components->twoColumnDetail('Parcel maximum pickup radius', ($settings['parcel_dispatch_maximum_pickup_radius_km'] ?? 10).' km');
            $this->components->twoColumnDetail('Ride wave size', (string) ($settings['ride_hailing_dispatch_wave_size'] ?? 3));
            $this->components->twoColumnDetail('Ride wave interval', ($settings['ride_hailing_dispatch_wave_interval_seconds'] ?? 20).' seconds');
            $this->components->twoColumnDetail('Ride GPS freshness', ($settings['ride_hailing_dispatch_location_freshness_seconds'] ?? 180).' seconds');
        } else {
            $errors[] = 'business_settings table is missing.';
        }

        if ($errors !== []) {
            foreach ($errors as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        $this->components->info('Nearest-first dispatch prerequisites are ready. A supervised queue worker must still be running.');

        return self::SUCCESS;
    }

    private function checkTable(string $table, array &$errors, bool $required): void
    {
        $exists = Schema::hasTable($table);
        $this->components->twoColumnDetail("Table: {$table}", $exists ? '<fg=green>ready</>' : '<fg=red>missing</>');

        if ($required && ! $exists) {
            $errors[] = "{$table} table is missing; run migrations.";
        }
    }
}
