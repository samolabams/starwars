<?php

namespace App\Http\Middleware;

use Closure;

class ApiMiddleware
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
        $contentType = $request->header('Content-Type');

        if ($contentType !== 'application/json') {
            return response()->json([
                'error' => [
                    'http_code' => 415,
                    'message' => 'The Content-Type header must always be application/json',
                ]
            ], 415);
        }

        return $next($request);
    }
}
