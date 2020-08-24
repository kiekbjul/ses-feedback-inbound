<?php

namespace Kiekbjul\SesFeedbackInbound\Http\Controllers;

use Illuminate\Http\Request;
use Kiekbjul\SesFeedbackInbound\Events\SesInboundReceived;
use Kiekbjul\SesFeedbackInbound\Models\SesInbound;

class SesInboundController
{
    public function __invoke(Request $request)
    {
        $data = json_decode(
            $request->json('Message')
        );

        $inbound = SesInbound::make([
            'ses_message_id' => $data->mail->messageId,
            'full_message' => $data,
        ]);

        if (config('ses-feedback-inbound.should_save_inbound') === true) {
            $inbound->save();
        }

        SesInboundReceived::dispatch($inbound);

        return response()->json([
            'success' => true,
            'message' => 'Inbound processed',
        ]);
    }
}
