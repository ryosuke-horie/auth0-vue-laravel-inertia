<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessReview
 *
 * @property int $review_id
 * @property int $business_id
 * @property int $user_id
 * @property string $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property BusinessOperator $business_operator
 * @property User $user
 *
 * @package App\Models
 */
class BusinessReview extends Model
{
    protected $table = 'business_reviews';
    protected $primaryKey = 'review_id';

    protected $casts = [
        'business_id' => 'int',
        'user_id' => 'int'
    ];

    protected $fillable = [
        'business_id',
        'user_id',
        'comment'
    ];

    public function businessOperator()
    {
        return $this->belongsTo(BusinessOperator::class, 'business_id');
    }

    /**
     * 事業者口コミ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
