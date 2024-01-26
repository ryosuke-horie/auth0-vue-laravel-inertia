<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 *
 * @property int $entity_id
 * @property int $entity_type
 * @property string $token
 * @property bool $is_active
 * @property Carbon|null $end_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Token extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'token';

    protected $casts = [
        'entity_id' => 'int',
        'entity_type' => 'int',
        'is_active' => 'bool',
        'end_at' => 'datetime'
    ];

    protected $hidden = [
        'token'
    ];

    protected $fillable = [
        'entity_id',
        'entity_type',
        'email',
        'token',
        'end_at'
    ];
}
