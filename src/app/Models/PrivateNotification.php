<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PrivateNotification
 *
 * @property int $notification_id
 * @property int $entity_type
 * @property int $entity_id
 * @property string $title
 * @property string $content
 * @property bool $is_read
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PrivateNotification extends Model
{
    use HasFactory;

    protected $table = 'private_notifications';
    protected $primaryKey = 'notification_id';

    protected $casts = [
        'entity_type' => 'int',
        'entity_id' => 'int',
        'is_read' => 'bool',
        'start_at' => 'datetime',
        'end_at' => 'datetime'
    ];

    protected $fillable = [
        'entity_type',
        'entity_id',
        'title',
        'content',
        'is_read',
        'start_at',
        'end_at'
    ];
}
