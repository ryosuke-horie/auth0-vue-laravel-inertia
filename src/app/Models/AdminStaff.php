<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Notifications\AdminStaff\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Staff
 *
 * @property int $staff_id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property int $business_id
 * @property string $real_name
 * @property string $staff_name
 * @property string|null $comment
 * @property bool $is_admin_staff
 * @property bool $is_deleted
 * @property int $points
 * @property int|null $admin_staff_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property BusinessOperator $business_operator
 * @property Collection|StaffProfileImage[] $staff_profile_images
 * @property Collection|UserTip[] $user_tips
 * @property Collection|StaffFavorite[] $staff_favorites
 * @property Collection|StaffSchedule[] $staff_schedules
 * @property Collection|StaffNotification[] $staff_notifications
 * @property Collection|UserLike[] $user_likes
 *
 * @package App\Models
 */
class AdminStaff extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
    use HasFactory;

    protected $table = 'admin_staff';
    protected $primaryKey = 'admin_staff_id';

    protected $casts = [
        'admin_staff_id' => 'int',
        'business_id' => 'int',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'admin_staff_id',
        'business_id',
        'password',
        'remember_token',
        'name',
        'email'
    ];


    /**
     * 事業者情報
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function businessOperator()
    {
        return $this->belongsTo(BusinessOperator::class, 'business_id', 'business_id');
    }

    /**
     * 中間テーブルスタッフ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'admin_staff_staff', 'admin_staff_id', 'staff_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
