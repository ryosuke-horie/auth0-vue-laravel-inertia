<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffReply
 *
 * @property int $reply_id
 * @property int $tip_id
 * @property string $message
 * @property Carbon $created_at
 *
 * @property UserTip $user_tip
 * @property Collection|ReplyMedia[] $reply_media
 *
 * @package App\Models
 */
class StaffReply extends Model
{
    protected $table = 'staff_replies';
    protected $primaryKey = 'reply_id';
    public $timestamps = false;

    protected $casts = [
        'tip_id' => 'int'
    ];

    protected $fillable = [
        'tip_id',
        'message'
    ];

    public function userTip()
    {
        return $this->belongsTo(UserTip::class, 'tip_id');
    }

    public function replyMedia()
    {
        return $this->hasOne(ReplyMedia::class, 'reply_id');
    }
}
