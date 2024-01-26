<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Notifications\Corporation\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Corporation
 *
 * @property int $corporation_id
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $corporation_application_id
 * @property string $corporation_name
 * @property string $applicant_name
 * @property string $applicant_name_kana
 * @property string $zip_code
 * @property string $pref_code
 * @property string $city
 * @property string $phone
 * @property string $invoice_reg_num
 * @property string|null $notes
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property CorporationApplication|null $corporation_application
 * @property Collection|BusinessOperator[] $business_operators
 *
 * @package App\Models
 */
class Corporation extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'corporations';
    protected $primaryKey = 'corporation_id';

    protected $casts = [
        'corporation_application_id' => 'int',
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
        'corporation_application_id',
        'corporation_name',
        'applicant_name',
        'applicant_name_kana',
        'zip_code',
        'pref_code',
        'city',
        'phone',
        'invoice_reg_num',
        'notes',
        'is_deleted'
    ];

    public function corporationApplication()
    {
        return $this->belongsTo(CorporationApplication::class);
    }

    /**
     * 事業者情報
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businessOperators()
    {
        return $this->hasMany(BusinessOperator::class, 'corporation_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
