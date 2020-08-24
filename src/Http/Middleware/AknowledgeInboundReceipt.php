<?php

namespace Kiekbjul\SesFeedbackInbound\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kiekbjul\SesFeedbackInbound\Events\SesInboundSetupCompleted;
use Kiekbjul\SesFeedbackInbound\Models\SesInbound;

class AknowledgeInboundReceipt
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        return $this->isInboundReceipt($request)
            ? $this->aknowledgeInboundReceipt($request)
            : $next($request);
    }

    private function isInboundReceipt($request): bool
    {
        return $this->message($request)->mail->messageId === 'AMAZON_SES_SETUP_NOTIFICATION';
    }

    private function message($request)
    {
        return json_decode($request->json('Message'));
    }

    private function aknowledgeInboundReceipt($request)
    {
        $data = $this->message($request);

        $inbound = SesInbound::make([
            'ses_message_id' => $data->mail->messageId,
            'full_message' => $data,
        ]);

        SesInboundSetupCompleted::dispatch($inbound);

        return response()->json([
            'success' => true,
            'message' => 'Inbound receipt aknowledged.',
        ]);
    }
}
