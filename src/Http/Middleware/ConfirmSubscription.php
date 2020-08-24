<?php
namespace Kiekbjul\SesFeedbackInbound\Http\Middleware;

use Aws\Sns\Message;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Kiekbjul\SesFeedbackInbound\Events\SnsSubscriptionConfirmed;

class ConfirmSubscription
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        return $this->isSubscriptionConfirmation($request)
            ? $this->confirmSubscription($request)
            : $next($request);
    }

    private function isSubscriptionConfirmation($request): bool
    {
        return $request->json('Type', null) === 'SubscriptionConfirmation';
    }

    private function confirmSubscription($request)
    {
        Http::get($request->json('SubscribeURL'));

        SnsSubscriptionConfirmed::dispatch(
            Route::currentRouteName()
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscription confirmed.'
        ]);
    }
}
