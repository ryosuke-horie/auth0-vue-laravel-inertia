<?php

namespace App\Http\Controllers\User;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Services\GuestUserService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class GuestLoginController extends Controller
{
    protected $guestUserService;

    /**
     * @param  GuestUserService  $guestUserService
     * @return void
     */
    public function __construct(GuestUserService $guestUserService)
    {
        $this->guestUserService = $guestUserService;
    }

    /**
     * ゲストユーザーでログイン
     *
     * @return RedirectResponse
     */
    public function guestLogin(): RedirectResponse
    {
        // テスト用ユーザーの情報を取得
        $user = $this->guestUserService->getGuestUser();

        if (!$user) {
            $this->guestUserService->createGuest([
                'email'  => 'guest@example.com',
                'password'  => bcrypt('password123'),
                'email_verified_at' => Carbon::now(),
                'nickname' => 'ゲストユーザー',
                'birthdate' => '1990-01-01',
            ]);
        }

        // テスト用ユーザーでログイン
        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::USER_HOME);
    }
}
