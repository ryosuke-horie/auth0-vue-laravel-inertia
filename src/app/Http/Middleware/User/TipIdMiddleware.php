<?php

declare(strict_types=1);

namespace App\Http\Middleware\User;

use App\Repositories\UserTip\UserTipRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TipIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $tipId = $request->route()->parameter('tipId');

        $userId = Auth::guard('user')->user()->user_id;

        $userTipRepository = app()->make(UserTipRepositoryInterface::class);
        $userTips = $userTipRepository->getAllByUserId($userId);
        $userTipIds = $userTips->pluck('tip_id');

        $isMatch = $userTipIds->contains($tipId);

        if ($isMatch) {
            return $next($request);
        }

        abort(404);
    }
}
