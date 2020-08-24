<?php

namespace Kiekbjul\SesFeedbackInbound\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Kiekbjul\SesFeedbackInbound\Models\SesInbound;

class SesInboundReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $inbound;

    /**
     * Create a new event instance.
     *
     * @param  \Kiekbjul\SesFeedbackInbound\Models\SesInbound  $inbound
     * @return void
     */
    public function __construct(SesInbound $inbound)
    {
        $this->inbound = $inbound;
    }
}
