<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PointDetail
 *
 * @property int $detail_id
 * @property int $buy_id
 * @property int|null $buy_points
 * @property int|null $remaining_points
 * @property bool $is_point_usable
 * @property Carbon $expiration_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property PointBuyHistory $point_buy_history
 * @property Collection|PointUsageHistory[] $point_usage_histories
 *
 * @package App\Models
 */
class PointDetail extends Model
{
    protected $table = 'point_details';
    protected $primaryKey = 'detail_id';

    protected $casts = [
        'buy_id' => 'int',
        'buy_points' => 'int',
        'remaining_points' => 'int',
        'is_point_usable' => 'bool',
        'expiration_date' => 'datetime'
    ];

    protected $fillable = [
        'buy_id',
        'buy_points',
        'remaining_points',
        'is_point_usable',
        'expiration_date'
    ];

    public function pointBuyHistory()
    {
        return $this->belongsTo(PointBuyHistory::class, 'buy_id');
    }

    public function pointUsageHistories()
    {
        return $this->hasMany(PointUsageHistory::class, 'detail_id');
    }
}
