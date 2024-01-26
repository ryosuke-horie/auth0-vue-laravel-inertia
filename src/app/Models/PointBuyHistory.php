<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PointBuyHistory
 *
 * @property int $buy_id
 * @property int $user_id
 * @property int $buy_points
 * @property float $amount
 * @property bool $is_success
 * @property string $payment_method
 * @property string $payment_number
 * @property bool $is_paid
 * @property Carbon|null $payment_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|PointDetail[] $point_details
 *
 * @package App\Models
 */
class PointBuyHistory extends Model
{
    protected $table = 'point_buy_histories';
    protected $primaryKey = 'buy_id';

    protected $casts = [
        'user_id' => 'int',
        'buy_points' => 'int',
        'amount' => 'float',
        'is_success' => 'bool',
        'is_paid' => 'bool',
        'payment_at' => 'datetime'
    ];

    protected $fillable = [
        'user_id',
        'buy_points',
        'amount',
        'is_success',
        'payment_method',
        'payment_number',
        'is_paid',
        'payment_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pointDetails()
    {
        return $this->hasMany(PointDetail::class, 'buy_id');
    }
}
