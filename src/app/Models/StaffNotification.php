<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffNotification
 *
 * @property int $notification_id
 * @property int $staff_id
 * @property bool $is_message_notified
 * @property string|null $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Staff $staff
 *
 * @package App\Models
 */
class StaffNotification extends Model
{
    protected $table = 'staff_notifications';
    protected $primaryKey = 'notification_id';

    protected $casts = [
        'staff_id' => 'int',
        'is_message_notified' => 'bool'
    ];

    protected $hidden = [
        'token'
    ];

    protected $fillable = [
        'staff_id',
        'is_message_notified',
        'token'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
