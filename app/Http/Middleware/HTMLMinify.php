<?php

namespace App\Http\Middleware;

use App\Helpers\TinyHtmlMinifier;
use Closure;

class HTMLMinify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);
        return response(TinyHtmlMinifier::html($response));
    }
}
