<?php

namespace App\Jobs;

use App\CentralLogics\Helpers;
use App\Models\Admin;
use App\Queue\Middleware\EnsureQueueProcessEnabled;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOpsManagerNotification implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $timeout = 60;

    public int $uniqueFor = 86400;

    public function __construct(
        public int $managerId,
        public string $eventId,
        public string $eventType,
        public string $title,
        public string $message,
        public ?int $applicationId = null,
        public ?int $withdrawalId = null,
    ) {
        $this->afterCommit();
    }

    public function handle(): void
    {
        $manager = Admin::query()->find($this->managerId);
        if (! $manager?->ops_fcm_token || ! $manager->canUseOps()) {
            return;
        }
        $accepted = Helpers::send_push_notif_to_device($manager->ops_fcm_token, [
            'title' => $this->title,
            'description' => $this->message,
            'image' => '',
            'type' => 'ops_event',
            'event_type' => $this->eventType,
            'event_id' => $this->eventId,
            'application_id' => $this->applicationId,
            'withdrawal_id' => $this->withdrawalId,
        ]);
        if (! $accepted) {
            throw new \RuntimeException('Firebase did not accept the Zaqoota Ops notification.');
        }
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('ops_manager_notifications')];
    }

    public function backoff(): array
    {
        return [60, 300, 900, 3600];
    }

    public function uniqueId(): string
    {
        return $this->managerId.':'.$this->eventId;
    }
}
