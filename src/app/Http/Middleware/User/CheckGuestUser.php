<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Http\Request;

class CheckGuestUser
{
    /**
     * リクエストを処理します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $isGuestUser = $request->user() && $request->user()->user_id === 1;
        $request->attributes->set('isGuestUser', $isGuestUser);

        return $next($request);
    }
}
