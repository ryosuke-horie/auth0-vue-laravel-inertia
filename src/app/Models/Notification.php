<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NotificationRead;

/**
 * Class Notification
 *
 * @property int $notification_id
 * @property int $entity_type
 * @property string $title
 * @property string|null $content
 * @property string|null $file_type
 * @property string|null $file_name
 * @property int|null $file_size
 * @property string $title
 * @property Carbon $start_at
 * @property Carbon|null $end_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|NotificationRead[] $notificationReads
 *
 * @package App\Models
 */
class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';

    protected $casts = [
        'entity_type' => 'int',
        'file_size' => 'int',
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    protected $fillable = [
        'entity_type',
        'title',
        'content',
        'file_type',
        'file_name',
        'file_size',
        'start_at',
        'end_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notificationReads()
    {
        return $this->hasMany(NotificationRead::class, 'notification_id');
    }
}
