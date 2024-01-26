<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLike
 *
 * @property int $like_id
 * @property int $user_id
 * @property int $staff_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Staff $staff
 *
 * @package App\Models
 */
class UserLike extends Model
{
    protected $table = 'user_likes';
    protected $primaryKey = 'like_id';

    protected $casts = [
        'user_id' => 'int',
        'staff_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'staff_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }
}
