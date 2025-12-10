<?php

namespace App\Events;

use App\Models\SosAlert;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SosAlertCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public SosAlert $alert;

    public function __construct(SosAlert $alert)
    {
        $this->alert = $alert->load('user');
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('private-admin-sos')];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->alert->id,
            'user' => [
                'id' => $this->alert->user->id ?? null,
                'name' => $this->alert->user->name ?? 'Unknown',
            ],
            'latitude' => $this->alert->latitude,
            'longitude' => $this->alert->longitude,
            'message' => $this->alert->message,
            'status' => $this->alert->status,
            'created_at' => optional($this->alert->created_at)->toDateTimeString(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'SosAlertCreated';
    }
}

