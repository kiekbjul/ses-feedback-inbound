<?php

namespace Kiekbjul\SesFeedbackInbound\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Kiekbjul\SesFeedbackInbound\Models\SesFeedback;

class SesFeedbackReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $feedback;

    /**
     * Create a new event instance.
     *
     * @param  \Kiekbjul\SesFeedbackInbound\Models\SesFeedback  $feedback
     * @return void
     */
    public function __construct(SesFeedback $feedback)
    {
        $this->feedback = $feedback;
    }
}
