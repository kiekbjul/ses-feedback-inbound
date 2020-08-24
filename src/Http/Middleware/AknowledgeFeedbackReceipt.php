<?php

namespace Kiekbjul\SesFeedbackInbound\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kiekbjul\SesFeedbackInbound\Events\SesFeedbackSetupCompleted;

class AknowledgeFeedbackReceipt
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        return $this->isEventReceipt($request)
            ? $this->aknowledgeEventReceipt($request)
            : $next($request);
    }

    private function isEventReceipt($request): bool
    {
        return $request->json('Message') === 'Successfully validated SNS topic for Amazon SES event publishing.';
    }

    private function aknowledgeEventReceipt($request)
    {
        SesFeedbackSetupCompleted::dispatch();

        return response()->json([
            'success' => true,
            'message' => 'Event Publishing receipt aknowledged.',
        ]);
    }
}
