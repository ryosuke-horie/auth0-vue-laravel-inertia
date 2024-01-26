<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PointFluctuationHistory
 *
 * @property int $fluctuation_id
 * @property int $entity_type
 * @property int $entity_id
 * @property float $point_change
 * @property int $transaction_id
 * @property int $transaction_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PointFluctuationHistory extends Model
{
    protected $table = 'point_fluctuation_histories';
    protected $primaryKey = 'fluctuation_id';

    protected $casts = [
        'entity_type' => 'int',
        'entity_id' => 'int',
        'point_change' => 'float',
        'transaction_id' => 'int',
        'transaction_type' => 'int'
    ];

    protected $fillable = [
        'entity_type',
        'entity_id',
        'point_change',
        'transaction_id',
        'transaction_type'
    ];
}
