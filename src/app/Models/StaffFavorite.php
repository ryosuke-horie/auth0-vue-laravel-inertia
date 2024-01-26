<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffFavorite
 *
 * @property int $favorite_id
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
class StaffFavorite extends Model
{
    protected $table = 'staff_favorites';
    protected $primaryKey = 'favorite_id';

    protected $casts = [
        'user_id' => 'int',
        'staff_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'staff_id'
    ];

    /**
     * 投げ銭ユーザー
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * スタッフ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
