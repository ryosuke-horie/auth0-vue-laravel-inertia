<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserProfileImage;
use App\Models\StaffFavorite;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * ゲストユーザー取得
     *
     * @return User|null
     */
    public function getGuestUser(): ?User;

    /**
     * ゲストユーザー作成
     *
     * @param array $attributes
     * @return User
     */
    public function createGuestUser(array $attributes): User;

    /**
     * ユーザーのプロフィール画像を取得
     * ユーザー情報、ユーザープロフィール画像
     *
     * @param int $userId
     * @return User
     */
    public function getUserProfileImageByUserId(int $userId): User;

    /**
     * ユーザーのお気に入りスタッフ情報+スタッフスケジュールを取得
     *
     * @param int $userId
     * @return User|null
     */
    public function getStaffFavoritesOrSchedulesByUserId(int $userId): ?User;

    /**
     * ユーザーのお気に入りスタッフ情報を取得
     *
     * @param int $userId
     * @return User|null
     */
    public function getStaffFavoritesByUserId(int $userId): ?User;

    /**
     * お気に入りスタッフ情報取得
     *
     * @param int $userId
     * @param int $staffId
     * @return StaffFavorite|null
     */
    public function findUserWithFavoriteStaff(int $userId, int $staffId): ?StaffFavorite;

    /**
    * お気に入りスタッフ切り替え
    *
    * @param int $userId
    * @param int $staffId
    * @param int|null $favoriteId
    * @return ?int
    */
    public function toggleFavorite(int $userId, int $staffId, ?int $favoriteId): ?int;

    /**
     * いいね切り替え
     *
     * @param int $userId
     * @param int $staffId
     * @param int|null $likeId
     * @return ?int
     */
    public function toggleUserLike(int $userId, int $staffId, ?int $likeId): ?int;

    /**
     * 保有ポイントを更新
     *
     * @param int $userid
     * @param int $freePoints
     * @param int $paidPoints
     * @param int $amount
     * @return void
     */
    public function updateUserPoints(int $userid, int $freePoints, int $paidPoints, int $amount): void;

    /**
     * Stripeの公開鍵取得
     *
     * @return string STRIPE_KEY
     */
    public function getStripeKey(): string;

    /**
     * 指定された顧客IDに対応する支払い方法を取得
     *
     * @param string $stripeId Stripeの顧客ID
     * @return array Stripeの支払い方法の配列
     */
    public function getPaymentMethods(string $stripeId): array;

    /**
     * 支払い意向（PaymentIntent）作成
     *
     * @param int $amount 支払い金額
     * @param string $currency 通貨コード（デフォルトは 'jpy'）
     * @return PaymentIntent 作成されたPaymentIntentオブジェクト
     */
    public function createPaymentIntent($amount, $currency = 'jpy'): PaymentIntent;

    /**
     * ユーザーにStripe IDがなければStripe顧客を作成
     *
     * @param User $user
     * @return Object|null
     */
    public function createStripeCustomerIfNeeded(User $user): ?object;
    /**
        * Stripe顧客を作成または更新
        *
        * @param object $user ユーザー情報オブジェクト
        * @param string $token Stripeトークン
        * @return void 顧客情報をデータベースに保存するため戻り値はなし
        */
    public function createOrUpdateStripeCustomer(object $user, string $token): void;

    /**
     * Stripe上の支払い方法を削除
     *
     * @param string $paymentMethodId 削除する支払い方法のID
     * @throws ApiErrorException Stripe APIエラー
     */
    public function deletePaymentMethod(string $paymentMethodId): void;
}
