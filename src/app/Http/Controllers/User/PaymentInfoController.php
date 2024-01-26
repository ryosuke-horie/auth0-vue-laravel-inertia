<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PaymentInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class PaymentInfoController extends Controller
{
    protected $paymentInfoService;

    /**
     * @param  PaymentInfoService  $paymentInfoService
     * @return void
     */
    public function __construct(PaymentInfoService $paymentInfoService)
    {
        $this->paymentInfoService = $paymentInfoService;
    }

    /**
     * 支払い情報の詳細画面を表示
     *
     * @return Response
     */
    public function show(): Response
    {
        // ユーザーがStripeの顧客情報を持っていなければ作成する
        $user = Auth::guard('user')->user();
        $this->paymentInfoService->createStripeCustomerIfNeeded($user);

        return Inertia::render('User/PaymentInfo/show', [
            'stripeKey' => $this->paymentInfoService->getStripeKey(),
        ]);
    }

    /**
     * 支払い情報の登録画面を表示
     *
     * @return Response
     */
    public function create(): Response
    {

        return Inertia::render('User/PaymentInfo/create', [
            'stripeKey' => $this->paymentInfoService->getStripeKey(),
        ]);
    }

    /**
     * 支払い情報の確認画面を表示
     *
     * @param Request $request
     * @return Response
     */
    public function confirm(Request $request): Response
    {
        $confirmationData = $this->paymentInfoService->prepareConfirmationData(
            $request->token,
            $request->brand,
            $request->last4
        );

        return Inertia::render('User/PaymentInfo/confirm', $confirmationData);
    }


    /**
     * 支払い方法を取得（API）
     *
     * @return JsonResponse
     */
    public function getPaymentMethods(): JsonResponse
    {
        $stripeId = optional(Auth::guard('user')->user())->stripe_id;

        return empty($stripeId)
            ? response()->json('')
            : response()->json($this->paymentInfoService->getPaymentMethods($stripeId));
    }

    /**
     * 顧客情報を登録（API）
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createPaymentIntent(Request $request): JsonResponse
    {
        $user = Auth::guard('user')->user();
        $this->paymentInfoService->createStripeCustomerIfNeeded($user);

        return $this->paymentInfoService->createPaymentIntent($request->amount);
    }

    /**
     * 支払い方法を登録（API）
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function registerPaymentMethod(Request $request): JsonResponse
    {
        $user = $request->user();
        $token = $request->input('token');

        $response = $this->paymentInfoService->registerPaymentMethod($user, $token);
        return response()->json($response);
    }

    /**
     * 支払い方法を削除（API）
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deletePaymentMethod(Request $request): JsonResponse
    {
        $paymentMethodId = $request->input('paymentMethodId');
        $response = $this->paymentInfoService->deletePaymentMethod($paymentMethodId);
        return response()->json($response);
    }
}
