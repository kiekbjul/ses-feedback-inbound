<?php

namespace Kiekbjul\SesFeedbackInbound\Http\Middleware;

use Aws\Sns\Message;
use Aws\Sns\MessageValidator;
use Closure;
use Illuminate\Http\Request;
use Throwable;

class VerifySnsSignature
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        try {
            $message = Message::fromJsonString($request->getContent());

            $validator = new MessageValidator();
            $validator->validate($message);
        } catch (Throwable $e) {
            abort(404, 'Not Found');
        }

        return $next($request);
    }
}
