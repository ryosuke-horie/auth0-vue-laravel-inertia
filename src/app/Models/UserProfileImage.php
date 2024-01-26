<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserProfileImage
 *
 * @property int $image_id
 * @property int $user_id
 * @property string $file_type
 * @property string $file_name
 * @property int|null $file_size
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class UserProfileImage extends Model
{
    protected $table = 'user_profile_images';
    protected $primaryKey = 'image_id';

    protected $casts = [
        'user_id' => 'int',
        'file_size' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'file_type',
        'file_name',
        'file_size'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
