<?php
namespace Kiekbjul\SesFeedbackInbound\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kiekbjul\SesFeedbackInbound\Models\SesFeedback;
use Illuminate\Support\Str;
use Kiekbjul\SesFeedbackInbound\Events\SesFeedbackReceived;

class SesFeedbackController
{
    public function __invoke(Request $request)
    {
        $data = json_decode(
            $request->json('Message')
        );

        $feedback = SesFeedback::make([
            'ses_message_id' => $data->mail->messageId,
            'type' => Str::lower($data->eventType),
            'full_message' => $data,
        ]);

        if (config('ses-feedback-inbound.should_save_feedback') === true) {
            $feedback->save();
        }

        SesFeedbackReceived::dispatch($feedback);

        return response()->json([
            'success' => true,
            'message' => 'Feedback processed',
        ]);
    }
}
