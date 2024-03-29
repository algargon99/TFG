<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:8080,http://localhost:8000,http://localhost:80,http://localhost');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        
        return $response;
    }
}