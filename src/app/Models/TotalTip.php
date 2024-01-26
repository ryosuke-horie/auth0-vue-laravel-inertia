<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TotalTip
 *
 * @property int $total_tip_id
 * @property string $year_month
 * @property int $entity_type
 * @property int $entity_id
 * @property int $total_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TotalTip extends Model
{
    protected $table = 'total_tips';
    protected $primaryKey = 'total_tip_id';

    protected $casts = [
        'entity_type' => 'int',
        'entity_id' => 'int',
        'total_amount' => 'int'
    ];

    protected $fillable = [
        'year_month',
        'entity_type',
        'entity_id',
        'total_amount'
    ];
}
