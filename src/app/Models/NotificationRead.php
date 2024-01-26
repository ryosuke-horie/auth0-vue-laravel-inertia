<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationRead
 *
 * @property int $read_id
 * @property int $notification_id
 * @property int $entity_type
 * @property int $entity_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Notification $notification
 *
 * @package App\Models
 */
class NotificationRead extends Model
{
    use HasFactory;

    protected $table = 'notification_reads';
    protected $primaryKey = 'read_id';

    protected $casts = [
        'notification_id' => 'int',
        'entity_type' => 'int',
        'entity_id' => 'int'
    ];

    protected $fillable = [
        'notification_id',
        'entity_type',
        'entity_id'
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
