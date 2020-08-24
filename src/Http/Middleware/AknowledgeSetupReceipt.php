<?php
namespace Kiekbjul\SesFeedbackInbound\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Kiekbjul\SesFeedbackInbound\Events\SesInboundSetupCompleted;
use Kiekbjul\SesFeedbackInbound\Models\SesInbound;

class AknowledgeSetupReceipt
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        return $this->isSetupReceipt($request)
            ? $this->aknowledgeSetupReceipt($request)
            : $next($request);
    }

    private function isSetupReceipt($request): bool
    {
        return $this->message($request)->mail->messageId === 'AMAZON_SES_SETUP_NOTIFICATION';
    }

    private function message($request)
    {
        return json_decode($request->json('Message'));
    }

    private function aknowledgeSetupReceipt($request)
    {
        $data = $this->message($request);

        $inbound = SesInbound::make([
            'ses_message_id' => $data->mail->messageId,
            'full_message' => $data,
        ]);

        SesInboundSetupCompleted::dispatch($inbound);

        return response()->json([
            'success' => true,
            'message' => 'Setup receipt aknowledget.'
        ]);
    }
}
