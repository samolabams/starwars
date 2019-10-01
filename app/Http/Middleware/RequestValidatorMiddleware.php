<?php

namespace App\Http\Middleware;

use Closure;

class RequestValidatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->method(), ['PUT', 'POST', 'PATCH'])) {

            if ($request->header('Content-Type') !== 'application/json') {
                return response()->json([
                    'error' => [
                        'http_code' => 415,
                        'message' => 'The Content-Type header must always be application/json',
                    ]
                ], 415);
            }
            
        }

        return $next($request);
    }
}
