<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Illuminate\Http\JsonResponse;

class PaymentInfoService
{
    protected $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Stripeの公開鍵取得
     *
     * @return string
     */
    public function getStripeKey(): string
    {
        return $this->userRepository->getStripeKey();
    }

    /**
     * クレカ情報を確認ページへ送るためにデータ加工
     *
     * @param string $token
     * @param string $brand
     * @param string $last4
     * @return array
     */
    public function prepareConfirmationData(string $token, string $brand, string $last4): array
    {
        return [
            'stripeKey' => $this->getStripeKey(),
            'token' => $token,
            'brand' => $brand,
            'last4' => $last4,
        ];
    }

    /**
     * 支払い方法を取得
     *
     * @param string $stripeId Stripeの顧客ID
     * @return array Stripeから取得した支払い方法の配列
     * @throws ApiErrorException Stripe APIの呼び出しで問題が発生した場合にスロー
     */
    public function getPaymentMethods(string $stripeId): array
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        return $this->userRepository->getPaymentMethods($stripeId);
    }

    /**
     * Stripeの顧客情報を作成
     *
     * @param User $user
     * @return Object|null
     */
    public function createStripeCustomerIfNeeded(User $user): ?object
    {
        return $this->userRepository->createStripeCustomerIfNeeded($user);
    }

    /**
     * 支払い意向を作成
     *
     * @param int $amount 支払い金額
     * @return JsonResponse
     */
    public function createPaymentIntent(int $amount): JsonResponse
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntent = $this->userRepository->createPaymentIntent($amount);
        return response()->json($paymentIntent);
    }

    /**
     * 支払い方法を登録
     *
     * @param object $user ユーザー情報オブジェクト
     * @param string $token Stripeトークン
     * @return array 登録処理の結果
     */
    public function registerPaymentMethod(object $user, string $token): array
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->userRepository->createOrUpdateStripeCustomer($user, $token);
        return ['message' => '支払い方法が登録されました'];
    }

    /**
     * 支払い方法を削除
     *
     * @param string $paymentMethodId 削除する支払い方法のID
     * @return array 削除処理の結果
     */
    public function deletePaymentMethod(string $paymentMethodId): array
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $this->userRepository->deletePaymentMethod($paymentMethodId);
            return ['success' => true];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
