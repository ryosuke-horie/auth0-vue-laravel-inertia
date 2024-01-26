<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessTippingAmountSetting
 *
 * @property int $amount_setting_id
 * @property int $business_id
 * @property int $setting_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property BusinessOperator $business_operator
 * @property TippingAmountSetting $tipping_amount_setting
 *
 * @package App\Models
 */
class BusinessTippingAmountSetting extends Model
{
    protected $table = 'business_tipping_amount_settings';
    protected $primaryKey = 'amount_setting_id';

    protected $casts = [
        'business_id' => 'int',
        'setting_id' => 'int'
    ];

    protected $fillable = [
        'business_id',
        'setting_id'
    ];

    public function businessOperator()
    {
        return $this->belongsTo(BusinessOperator::class, 'business_id');
    }

    /**
     * 投げ銭金額設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tippingAmountSetting()
    {
        return $this->belongsTo(TippingAmountSetting::class, 'setting_id');
    }
}
