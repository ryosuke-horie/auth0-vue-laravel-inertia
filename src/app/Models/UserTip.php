<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserTip
 *
 * @property int $tip_id
 * @property int $user_id
 * @property int $staff_id
 * @property string|null $guest_nickname
 * @property int $tipping_amount
 * @property string|null $message
 * @property int|null $desk_number
 * @property int $ai_count
 * @property bool $is_user_read
 * @property bool $is_staff_read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Staff $staff
 * @property Collection|PointUsageHistory[] $point_usage_histories
 * @property Collection|StaffReply[] $staff_replies
 *
 * @package App\Models
 */
class UserTip extends Model
{
    protected $table = 'user_tips';
    protected $primaryKey = 'tip_id';

    protected $casts = [
        'user_id' => 'int',
        'staff_id' => 'int',
        'tipping_amount' => 'int',
        'desk_number' => 'int',
        'ai_count' => 'int',
        'is_user_read' => 'bool',
        'is_staff_read' => 'bool'
    ];

    protected $fillable = [
        'user_id',
        'staff_id',
        'guest_nickname',
        'tipping_amount',
        'message',
        'desk_number',
        'ai_count',
        'is_user_read',
        'is_staff_read'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function pointUsageHistories()
    {
        return $this->hasMany(PointUsageHistory::class, 'tip_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function staffReply()
    {
        return $this->hasOne(StaffReply::class, 'tip_id', 'tip_id');
    }
}
