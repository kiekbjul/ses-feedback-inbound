<?php

namespace Kiekbjul\SesFeedbackInbound\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SnsSubscriptionConfirmed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $endpoint;

    /**
     * Create a new event instance.
     *
     * @param  string  $endpoint
     * @return void
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }
}
