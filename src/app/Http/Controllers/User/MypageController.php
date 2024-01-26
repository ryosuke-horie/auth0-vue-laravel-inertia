<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use App\Services\UserService;
use App\Enums\EntityType;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    // ユーザーのお知らせ情報を取得する
    private $notificationService;

    // ユーザー情報を取得する
    private $userService;

    public function __construct(
        NotificationService $notificationService,
        UserService $userService
    ) {
        $this->notificationService = $notificationService;
        $this->userService = $userService;
        $this->middleware('user');
    }

    /**
     * マイページを表示する
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        // ゲストユーザーかどうか判断
        $isGuestUser = $request->attributes->get('isGuestUser');

        // ユーザー情報取得
        $userId = Auth::guard('user')->user()->user_id;

        // マイページ情報取得
        $args = $this->userService->getMypage($userId);

        // お知らせ情報取得
        $notifications = $this->notificationService->list(EntityType::User, $userId, 3)->getList();

        return Inertia::render('User/Mypage/Mypage', [
            ...$args,
            'isGuestUser'   => $isGuestUser,
            'notifications' => $notifications,
        ]);
    }
}
