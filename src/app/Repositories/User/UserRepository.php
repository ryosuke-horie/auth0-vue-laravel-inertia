<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserProfileImage;
use App\Models\PaymentInfo;
use App\Models\StaffFavorite;
use App\Models\UserLike;
use Stripe\PaymentMethod;
use Stripe\PaymentIntent;
use Stripe\Customer as StripeCustomer;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * ゲストユーザー取得
     *
     * @return User|null
     */
    public function getGuestUser(): ?User
    {
        return User::findByEmail('guest@example.com');
    }

    /**
     * ゲストユーザー作成
     *
     * @param array $attributes
     * @return User
     */
    public function createGuestUser(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     * ユーザーのプロフィール画像を取得
     * ユーザー情報、ユーザープロフィール画像
     *
     * @param int $userId
     * @return User
     */
    public function getUserProfileImageByUserId(int $userId): User
    {
        return User::with('userProfileImage')->find($userId);
    }

    public function getStaffFavoritesByUserId(int $userId): ?User
    {
        return User::with([
            'staffFavorites.staff.staffProfileImages',
            'staffFavorites.staff.businessOperator',
            'staffFavorites.staff.staffFavorites' // N+1対策
        ])->find($userId);
    }

    /**
     * ユーザーのお気に入りスタッフ情報を取得
     * ユーザー情報、スタッフ情報、スタッフプロフィール画像、お気に入りスタッフ、
     * スタッフに紐づく事業者情報も取得
     *
     * @param int $userId
     * @return User|null
     */
    public function getStaffFavoritesOrSchedulesByUserId(int $userId): ?User
    {
        $today = now()->startOfDay();

        return User::with([
            'staffFavorites.staff.staffProfileImages',
            'staffFavorites.staff.businessOperator',
            'staffFavorites.staff.staffSchedules' => function ($query) use ($today) {
                $query->where('schedule_date', $today);
            },
            'staffFavorites.staff.staffFavorites' // N+1対策
        ])->find($userId);
    }

    /**
     * お気に入りスタッフ情報取得
     *
     * @param int $userId
     * @param int $staffId
     * @return StaffFavorite|null
     */
    public function findUserWithFavoriteStaff(int $userId, int $staffId): ?StaffFavorite
    {
        return StaffFavorite::where('user_id', $userId)
                            ->where('staff_id', $staffId)
                            ->first();
    }

    /**
     * お気に入りスタッフ切り替え
     *
     * @param int $userId
     * @param int $staffId
     * @param int|null $favoriteId
     * @return ?int
     */
    public function toggleFavorite(int $userId, int $staffId, ?int $favoriteId): ?int
    {
        if ($favoriteId) {
            StaffFavorite::destroy($favoriteId);
            return null; // 削除の場合はnullを返す
        } else {
            $newFavorite = StaffFavorite::create([
                'user_id'  => $userId,
                'staff_id' => $staffId,
            ]);
            return $newFavorite->favorite_id; // 新規作成の場合はfavoriteIdを返す
        }
    }

    /**
     * いいね切り替え
     *
     * @param int $userId
     * @param int $staffId
     * @param int|null $userLike
     * @return ?int
     */
    public function toggleUserLike(int $userId, int $staffId, ?int $userLike): ?int
    {
        if ($userLike) {
            UserLike::destroy($userLike);
            return null; // 削除の場合はnullを返す
        } else {
            $newFavorite = UserLike::create([
                'user_id'  => $userId,
                'staff_id' => $staffId,
            ]);
            return $newFavorite->like_id; // 新規作成の場合はfavoriteIdを返す
        }
    }

    public function updateUserPoints(int $userid, int $freePoints, int $paidPoints, int $amount): void
    {
        $user = User::find($userid);

        if ($user) {
            $user->update([
                'free_points'  => $freePoints,
                'paid_points'  => $paidPoints,
                'total_amount' => $user->total_amount + $amount
            ]);
        }
    }

    /***************************************************************
     * 以下よりStripe関係
     ***************************************************************/

    /**
     * Stripeの公開鍵取得
     *
     * @return string STRIPE_KEY
     */
    public function getStripeKey(): string
    {
        return env('STRIPE_KEY');
    }


    /**
     * 指定された顧客IDに対応する支払い方法を取得
     *
     * @param string $stripeId Stripeの顧客ID
     * @return array Stripeの支払い方法の配列
     */
    public function getPaymentMethods(string $stripeId): array
    {
        return PaymentMethod::all([
            'customer' => $stripeId,
            'type' => 'card',
        ])->data;
    }

    /**
     * 支払い意向（PaymentIntent）作成
     *
     * @param int $amount 支払い金額
     * @param string $currency 通貨コード（デフォルトは 'jpy'）
     * @return PaymentIntent 作成されたPaymentIntentオブジェクト
     */
    public function createPaymentIntent($amount, $currency = 'jpy'): PaymentIntent
    {
        return PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'payment_method_types' => ['card'],
        ]);
    }

    /**
     * ユーザーにStripe IDがなければStripe顧客を作成
     *
     * @param User $user
     * @return Object|null
     */
    public function createStripeCustomerIfNeeded(User $user): ?object
    {
        // 既にStripe顧客IDを持っている場合は何もしない
        if ($user->hasStripeId()) {
            return null;
        }
        return $user->createAsStripeCustomer([
            'name' => $user->nickname,
            'metadata' => [
                'user_id' => $user->user_id,
            ],
        ]);
    }


    /**
     * Stripe顧客を作成または更新
     *
     * @param object $user ユーザー情報オブジェクト
     * @param string $token Stripeトークン
     * @return void 顧客情報をデータベースに保存するため戻り値はなし
     */
    public function createOrUpdateStripeCustomer(object $user, string $token): void
    {
        if (!$user->stripe_id) {
            $customer = StripeCustomer::create([
                'name' => $user->nickname,
                'email' => $user->email,
                'source' => $token,
                'metadata' => ['user_id' => $user->id],
            ]);
            $user->stripe_id = $customer->id;
            $user->save();
        } else {
            StripeCustomer::update($user->stripe_id, ['source' => $token]);
        }
    }

    /**
     * Stripe上の支払い方法を削除
     *
     * @param string $paymentMethodId 削除する支払い方法のID
     * @throws \Stripe\Exception\ApiErrorException Stripe APIエラー
     */
    public function deletePaymentMethod(string $paymentMethodId): void
    {
        $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
        $paymentMethod->detach();
    }
}
