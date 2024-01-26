<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffSchedule
 *
 * @property int $schedule_id
 * @property int $staff_id
 * @property Carbon $schedule_date
 * @property int $shift_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Staff $staff
 *
 * @package App\Models
 */
class StaffSchedule extends Model
{
    protected $table = 'staff_schedules';
    protected $primaryKey = 'schedule_id';

    protected $casts = [
        'staff_id' => 'int',
        'schedule_date' => 'datetime',
        'shift_status' => 'int'
    ];

    protected $fillable = [
        'staff_id',
        'schedule_date',
        'shift_status'
    ];

    /**
     * スタッフ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
