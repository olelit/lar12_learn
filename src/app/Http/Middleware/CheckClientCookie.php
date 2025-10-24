<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckClientCookie
{
    public const string COOKIE_NAME = 'client_cookie';

    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie(self::COOKIE_NAME)) {
            $uuid = (string) Str::uuid();
            Cookie::queue(Cookie::forever(self::COOKIE_NAME, $uuid));
        }

        return $next($request);
    }
}
