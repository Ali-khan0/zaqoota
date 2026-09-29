<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DispatchOrderCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly array $channelNames,
        public readonly array $payload,
    ) {}

    public function broadcastOn(): array
    {
        return array_map(
            fn (string $channel) => new PrivateChannel($channel),
            array_values(array_unique($this->channelNames)),
        );
    }

    public function broadcastAs(): string
    {
        return 'dispatch.order.created';
    }

    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
