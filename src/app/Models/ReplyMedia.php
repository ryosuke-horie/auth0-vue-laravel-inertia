<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ReplyMedia
 *
 * @property int $media_id
 * @property int $reply_id
 * @property string $file_type
 * @property string $file_name
 * @property int|null $file_size
 * @property int|null $duration
 * @property bool $is_deleted
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property StaffReply $staff_reply
 *
 * @package App\Models
 */
class ReplyMedia extends Model
{
    protected $table = 'reply_media';
    protected $primaryKey = 'media_id';

    protected $casts = [
        'reply_id' => 'int',
        'file_size' => 'int',
        'duration' => 'int',
        'is_deleted' => 'bool'
    ];

    protected $fillable = [
        'reply_id',
        'file_type',
        'file_name',
        'file_size',
        'duration',
        'is_deleted'
    ];

    public function staffReply()
    {
        return $this->belongsTo(StaffReply::class, 'reply_id');
    }
}
