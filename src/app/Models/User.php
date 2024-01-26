<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Notifications\User\VerifyEmail;
use App\Notifications\User\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Cashier\Billable;

/**
 * Class User
 *
 * @property int $user_id
 * @property string $email
 * @property string|null $email_hash
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $email_verified_at
 * @property string $nickname
 * @property string $birthdate
 * @property int $paid_points
 * @property int $free_points
 * @property int $total_amount
 * @property int $ai_count
 * @property bool $is_show_ranking
 * @property bool $is_blocked
 * @property bool $is_deleted
 * @property Carbon|null $blocked_at
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|UserProfileImage[] $user_profile_images
 * @property Collection|PaymentInfo[] $payment_infos
 * @property Collection|PointBuyHistory[] $point_buy_histories
 * @property Collection|UserTip[] $user_tips
 * @property Collection|StaffFavorite[] $staff_favorites
 * @property Collection|businessReview[] $business_reviews
 * @property Collection|UserLike[] $user_likes
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Billable; // Stripeの課金機能を利用するためのトレイト
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'paid_points' => 'int',
        'free_points' => 'int',
        'total_amount' => 'int',
        'ai_count' => 'int',
        'is_show_ranking' => 'bool',
        'is_blocked' => 'bool',
        'is_deleted' => 'bool',
        'blocked_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'email',
        'email_hash',
        'password',
        'remember_token',
        'email_verified_at',
        'nickname',
        'birthdate',
        'paid_points',
        'free_points',
        'total_amount',
        'ai_count',
        'is_show_ranking',
        'is_blocked',
        'is_deleted',
        'blocked_at',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at'
    ];

    /**
     * ユーザープロフィール画像
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userProfileImage()
    {
        return $this->hasOne(UserProfileImage::class, 'user_id');
    }

    /**
     * 支払い情報
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentInfos()
    {
        return $this->hasMany(PaymentInfo::class);
    }

    /**
     * ポイント購入履歴
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pointBuyHistories()
    {
        return $this->hasMany(PointBuyHistory::class);
    }

    /**
     * 投げ銭
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userTips()
    {
        return $this->hasMany(UserTip::class);
    }

    /**
     * スタッフお気に入り
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function staffFavorites()
    {
        return $this->hasMany(StaffFavorite::class, 'user_id');
    }

    /**
     * 事業者コメント（口コミ）
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businessReviews()
    {
        return $this->hasMany(BusinessReview::class, 'user_id');
    }

    /**
     * いいね
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userLikes()
    {
        return $this->hasMany(UserLike::class);
    }

    /**
     * パスワードリセット通知の送信
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * メール認証通知の送信
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    /**
     * Emailの暗号化
     * Emailは検索で活用するため、ハッシュ化した値も保存する
     *
     * @param string $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Crypt::encryptString($value);
        $this->attributes['email_hash'] = hash('sha256', $value);
    }

    /**
     * Emailの復号化
     *
     * @param string $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /**
     * Emailで検索
     *
     * @param string $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
        $emailHash = hash('sha256', $email);
        return self::where('email_hash', $emailHash)->first();
    }
}
