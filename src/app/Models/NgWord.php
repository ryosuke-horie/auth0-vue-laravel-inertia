<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NgWord
 *
 * @property int $word_id
 * @property string $word
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class NgWord extends Model
{
    protected $table = 'ng_words';
    protected $primaryKey = 'word_id';

    protected $fillable = [
        'word'
    ];
}
