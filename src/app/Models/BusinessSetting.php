<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessSetting
 *
 * @property int $setting_id
 * @property int $business_id
 * @property bool $is_publish
 * @property bool $is_review_publish
 * @property bool $is_media_publish
 * @property bool $is_comment_publish
 * @property bool $is_staff_ranking_publish
 * @property bool $is_auto_apply
 * @property int $auto_apply_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property BusinessOperator $business_operator
 *
 * @package App\Models
 */
class BusinessSetting extends Model
{
    protected $table = 'business_settings';
    protected $primaryKey = 'setting_id';

    protected $casts = [
        'business_id' => 'int',
        'is_publish'    => 'bool',
        'is_review_publish' => 'bool',
        'is_media_publish' => 'bool',
        'is_comment_publish' => 'bool',
        'is_staff_ranking_publish' => 'bool',
        'is_auto_apply' => 'bool',
        'auto_apply_amount' => 'int'
    ];

    protected $fillable = [
        'business_id',
        'is_publish',
        'is_review_publish',
        'is_media_publish',
        'is_comment_publish',
        'is_staff_ranking_publish',
        'is_auto_apply',
        'auto_apply_amount'
    ];

    public function businessOperators()
    {
        return $this->belongsTo(BusinessOperator::class);
    }
}
