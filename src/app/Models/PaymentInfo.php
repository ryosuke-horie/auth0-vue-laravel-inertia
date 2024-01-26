<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentInfo
 *
 * @property int $payment_info_id
 * @property int $user_id
 * @property string $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class PaymentInfo extends Model
{
    protected $table = 'payment_info';
    protected $primaryKey = 'payment_info_id';

    protected $casts = [
        'user_id' => 'int'
    ];

    protected $hidden = [
        'token'
    ];

    protected $fillable = [
        'user_id',
        'token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
