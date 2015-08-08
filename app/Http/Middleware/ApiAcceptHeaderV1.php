<?php

namespace App\Http\Middleware;

use Closure;

class ApiAcceptHeaderV1
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
        $response = $next($request);

        $response->headers->set('Content-Type', 'application/vnd.fractal-api.v1+json');

        return $response;
    }
}
