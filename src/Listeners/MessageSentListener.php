<?php

namespace Kiekbjul\SesFeedbackInbound\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Kiekbjul\SesFeedbackInbound\Events\SesMessageSent;
use Kiekbjul\SesFeedbackInbound\Models\SesSentMessage;

class MessageSentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Mail\Events\MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $messageId = $event->message->getHeaders()->get('X-SES-Message-ID', 0);

        if ($messageId === null) {
            return;
        }

        $message = SesSentMessage::make([
            'ses_message_id' => $messageId->getFieldBody(),
            'full_message' => $event->message->getBody(),
        ]);

        if (config('ses-feedback-inbound.should_save_sent_messages') === true) {
            $message->save();
        }

        SesMessageSent::dispatch($message);
    }
}
