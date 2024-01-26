<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Notifications\BusinessOperator\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class BusinessOperator
 *
 * @property int $business_id
 * @property string $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $corporation_id
 * @property int $business_application_id
 * @property string|null $corporation_name
 * @property string|null $applicant_name
 * @property string|null $applicant_name_kana
 * @property string $business_name
 * @property string $zip_code
 * @property string $pref_code
 * @property string $city
 * @property string $phone
 * @property string $invoice_reg_num
 * @property string|null $business_form
 * @property string|null $business_description
 * @property int|null $first_desk_number
 * @property int|null $second_desk_number
 * @property int $business_status
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Corporation|null $corporation
 * @property BusinessApplication $business_application
 * @property Collection|Staff[] $staff
 * @property Collection|BusinessProfileImage[] $business_profile_images
 * @property Collection|BusinessTippingAmountSetting[] $business_tipping_amount_settings
 * @property Collection|businessReview[] $business_reviews
 *
 * @package App\Models
 */
class BusinessOperator extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'business_operators';
    protected $primaryKey = 'business_id';

    protected $casts = [
        'corporation_id' => 'int',
        'business_application_id' => 'int',
        'first_desk_number' => 'int',
        'second_desk_number' => 'int',
        'business_status' => 'int',
        'is_deleted' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'email',
        'password',
        'remember_token',
        'corporation_id',
        'business_application_id',
        'corporation_name',
        'applicant_name',
        'applicant_name_kana',
        'business_name',
        'zip_code',
        'pref_code',
        'city',
        'phone',
        'invoice_reg_num',
        'business_form',
        'business_description',
        'first_desk_number',
        'second_desk_number',
        'business_status',
        'is_deleted'
    ];

    /**
     * 法人
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function corporation()
    {
        return $this->belongsTo(Corporation::class, 'corporation_id');
    }

    /**
     * 申込申請
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function businessApplication()
    {
        return $this->belongsTo(BusinessApplication::class);
    }

    /**
     * スタッフ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function staff()
    {
        return $this->hasMany(Staff::class, 'business_id');
    }

    /**
     * 事業者画像
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businessProfileImages()
    {
        return $this->hasMany(BusinessProfileImage::class, 'business_id');
    }

    public function businessTippingAmountSettings()
    {
        return $this->hasMany(BusinessTippingAmountSetting::class, 'business_id');
    }

    /**
     * 口コミ
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businessReviews()
    {
        return $this->hasMany(BusinessReview::class, 'business_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
