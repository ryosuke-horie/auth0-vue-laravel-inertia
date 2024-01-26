<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inquiry
 *
 * @property int $inquiry_id
 * @property int $entity_type
 * @property int|null $entity_id
 * @property string $email
 * @property string $content
 * @property bool $is_reply
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Inquiry extends Model
{
    protected $table = 'inquiries';
    protected $primaryKey = 'inquiry_id';

    protected $casts = [
        'entity_type' => 'int',
        'entity_id' => 'int',
        'is_reply' => 'bool'
    ];

    protected $fillable = [
        'entity_type',
        'entity_id',
        'email',
        'content',
        'is_reply'
    ];
}
