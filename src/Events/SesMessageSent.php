<?php

namespace Kiekbjul\SesFeedbackInbound\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Kiekbjul\SesFeedbackInbound\Models\SesSentMessage;

class SesMessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @param  \Kiekbjul\SesFeedbackInbound\Models\SesSentMessage  $message
     * @return void
     */
    public function __construct(SesSentMessage $message)
    {
        $this->message = $message;
    }
}
