<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginHistory
 *
 * @property int $login_history_id
 * @property int $entity_type
 * @property int $entity_id
 * @property bool $is_successful
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class LoginHistory extends Model
{
    protected $table = 'login_histories';
    protected $primaryKey = 'login_history_id';

    protected $casts = [
        'entity_type' => 'int',
        'entity_id' => 'int',
        'is_successful' => 'bool'
    ];

    protected $fillable = [
        'entity_type',
        'entity_id',
        'is_successful'
    ];
}
