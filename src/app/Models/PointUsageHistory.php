<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PointUsageHistory
 *
 * @property int $usage_id
 * @property int|null $detail_id
 * @property int $tip_id
 * @property int $used_points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property PointDetail|null $point_detail
 * @property UserTip $user_tip
 *
 * @package App\Models
 */
class PointUsageHistory extends Model
{
    protected $table = 'point_usage_histories';
    protected $primaryKey = 'usage_id';

    protected $casts = [
        'detail_id' => 'int',
        'tip_id' => 'int',
        'used_points' => 'int'
    ];

    protected $fillable = [
        'detail_id',
        'tip_id',
        'used_points'
    ];

    public function pointDetail()
    {
        return $this->belongsTo(PointDetail::class, 'detail_id');
    }

    public function userTip()
    {
        return $this->belongsTo(UserTip::class, 'tip_id');
    }
}
