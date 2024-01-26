<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessProfileImage
 *
 * @property int $image_id
 * @property int $business_id
 * @property string $file_type
 * @property string $file_name
 * @property int|null $file_size
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property BusinessOperator $business_operator
 *
 * @package App\Models
 */
class BusinessProfileImage extends Model
{
    protected $table = 'business_profile_images';
    protected $primaryKey = 'image_id';

    protected $casts = [
        'business_id' => 'int',
        'file_size' => 'int',
        'order' => 'int'
    ];

    protected $fillable = [
        'business_id',
        'file_type',
        'file_name',
        'file_size',
        'order'
    ];

    public function businessOperator()
    {
        return $this->belongsTo(BusinessOperator::class, 'business_id');
    }
}
