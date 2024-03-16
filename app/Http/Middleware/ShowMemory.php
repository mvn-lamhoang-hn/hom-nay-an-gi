<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class ShowMemory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isset($request->memory) && $request->memory == "show"){
            dump("1: ".(memory_get_peak_usage(false)/1024/1024)." MiB");
            $response = $next($request);
            dump("2: ".(memory_get_peak_usage(false)/1024/1024)." MiB");
            return $response;
        }
        else {
            return $next($request);
        }
    }
}
