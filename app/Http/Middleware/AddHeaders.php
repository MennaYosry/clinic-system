<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Auth\Middleware\AddHeaders as Middleware;
// If Laravel >= 5.2 then delete 'use' and 'implements' of deprecated Middleware interface.
class AddHeaders extends Middleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', 'http://localhost:3000');
        // $response->header('another header', 'another value');
        // header("Access-Control-Allow-Origin: http://localhost");
        return $response;
    }
}