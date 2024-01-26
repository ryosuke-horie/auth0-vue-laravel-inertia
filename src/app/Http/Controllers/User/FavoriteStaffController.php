<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use Illuminate\Http\Request;

class FavoriteStaffController extends Controller
{
    // ユーザー情報を取得する
    private $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * マイページを表示する
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        // ユーザー情報取得
        $userId = Auth::guard('user')->user()->user_id;

        // お気に入りスタッフ取得
        $args = $this->userService->getFavoriteStaffList($userId);

        return Inertia::render(
            'User/FavoriteStaff/Index',
            $args
        );
    }
}
