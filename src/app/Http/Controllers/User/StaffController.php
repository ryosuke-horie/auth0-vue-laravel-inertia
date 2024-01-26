<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserTipStoreRequest;
use App\Services\BusinessOperatorService;
use App\Services\UserService;
use App\Services\UserTipService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    private UserService $userService;
    private UserTipService $userTipService;

    public function __construct(
        UserService $userService,
        UserTipService $userTipService
    ) {
        $this->userService = $userService;
        $this->userTipService = $userTipService;
    }

    /**
     * スタッフ一覧
     *
     * @return Response
     */
    public function index(int $businessId): Response
    {
        $args = $this->userService->getBusinessOperatorShowWithStaffDetail($businessId);
        return Inertia::render('User/BusinessOperator/Staff/Index', $args);
    }

    /**
     * スタッフ詳細
     *
     * @param int $businessId
     * @return Response
     */
    public function show(int $businessId, int $staffId): Response
    {
        $userId    = Auth::guard('user')->user()->user_id;
        $freePoint = Auth::guard('user')->user()->free_points;
        $paidPoint = Auth::guard('user')->user()->paid_points;
        $aiCount   = Auth::guard('user')->user()->ai_count;

        $args = $this->userService->getStaffDetail($userId, $businessId, $staffId, $freePoint, $paidPoint, $aiCount);
        return Inertia::render('User/BusinessOperator/Staff/Show', $args);
    }

    /**
     * 投げ銭登録
     *
     * @return Response
     */
    public function userTipStore(UserTipStoreRequest $request, int $businessId, int $staffId): Response
    {
        $userId = Auth::guard('user')->user()->user_id;
        $freePoints = Auth::guard('user')->user()->free_points;
        $paidPoints = Auth::guard('user')->user()->paid_points;

        // 最後の引数は卓番号が必要（QRコードで読み取り→クエリパラメータの値をセッション保持のイメージ）
        $this->userTipService->updateUserTips($userId, $staffId, $freePoints, $paidPoints, $request->message ?? null, $request->amount, 0);
        return Inertia::render('User/BusinessOperator/Staff/UserTipComplete', [
            'businessId' => $businessId,
            'staffId' => $staffId,
        ]);
    }

    /**
     * お気に入りスタッフ切り替え（API）
     *
     * @param Request $request
     * @param int $staffId
     * @return JsonResponse
     */
    public function toggleFavorite(Request $request, int $staffId): JsonResponse
    {
        $userId = Auth::guard('user')->user()->user_id;
        $favoriteId = $this->userService->toggleFavorite($userId, $staffId, $request->favoriteId ?? null);
        return response()->json($favoriteId);
    }

    /**
     * いいね切り替え（API）
     *
     * @param Request $request
     * @param int $staffId
     * @return JsonResponse
     */
    public function toggleUserlike(Request $request, int $staffId): JsonResponse
    {
        $userId = Auth::guard('user')->user()->user_id;
        $userLikeId = $this->userService->toggleUserLike($userId, $staffId, $request->userLikeId ?? null);
        return response()->json($userLikeId);
    }
}
