<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ReviewStoreRequest;
use App\Services\UserService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class BusinessOperatorController extends Controller
{
    private UserService $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * 事業者一覧
     *
     * @return Response
     */
    public function index(): Response
    {
        $args = $this->userService->getBusinessOperatorList();
        return Inertia::render('User/BusinessOperator/Index', $args);
    }

    /**
     * 事業者詳細
     *
     * @param int $businessId
     * @return Response
     */
    public function show(int $businessId): Response
    {
        // 事業者情報取得
        $businessOperator = $this->userService->getBusinessOperatorShowProfile($businessId);

        // スタッフ情報取得
        $staff = $this->userService->getBusinessOperatorShowWithStaff($businessId);

        // 口コミ取得(投げ銭履歴はあとで混ぜる)
        $businessReviews = $this->userService->getBusinessReviews($businessId);

        return Inertia::render('User/BusinessOperator/Show', [
            'userId' => Auth::guard('user')->user()->user_id,
            'businessId' => $businessId,
            'businessOperator' => $businessOperator,
            ...$staff,
            ...$businessReviews,
        ]);
    }

    /**
     * 口コミ投稿画面
     *
     * @param int $businessId
     * @return Response
     */
    public function createReview(int $businessId): Response
    {
        $userId   = Auth::guard('user')->user()->user_id;

        $args = $this->userService->getUserProfileImage($userId);
        return Inertia::render('User/BusinessOperator/CreateReview', [
            ...$args,
            'businessId' => $businessId,
        ]);
    }

    /**
     * 口コミ登録
     *
     * @param int $businessId
     * @param ReviewStoreRequest $reviewStoreRequest
     * @return RedirectResponse
     */
    public function storeReview(int $businessId, ReviewStoreRequest $reviewStoreRequest): RedirectResponse
    {
        $userId = Auth::guard('user')->user()->user_id;
        $this->userService->storeReview($businessId, $userId, $reviewStoreRequest->review);

        return Redirect::route('user.business-operator.show', [
            'businessId' => $businessId,
        ]);
    }

    /**
     * 口コミ削除(API)
     *
     * @param int $businessId
     * @param int $reviewId
     * @return bool
     */
    public function deleteReview(int $businessId, int $reviewId): bool
    {
        $userId   = Auth::guard('user')->user()->user_id;
        return $this->userService->deleteReview($businessId, $reviewId, $userId);
    }
}
