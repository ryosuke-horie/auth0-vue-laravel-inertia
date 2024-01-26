<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffProfileImage
 *
 * @property int $image_id
 * @property int $staff_id
 * @property string $file_type
 * @property string $file_name
 * @property int|null $file_size
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Staff $staff
 *
 * @package App\Models
 */
class StaffProfileImage extends Model
{
    protected $table = 'staff_profile_images';
    protected $primaryKey = 'image_id';

    protected $casts = [
        'staff_id' => 'int',
        'file_size' => 'int',
        'order' => 'int'
    ];

    protected $fillable = [
        'staff_id',
        'file_type',
        'file_name',
        'file_size',
        'order'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
