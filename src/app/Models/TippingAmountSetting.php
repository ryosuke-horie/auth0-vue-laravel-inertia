<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TippingAmountSetting
 *
 * @property int $setting_id
 * @property int $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|BusinessTippingAmountSetting[] $business_tipping_amount_settings
 *
 * @package App\Models
 */
class TippingAmountSetting extends Model
{
    protected $table = 'tipping_amount_settings';
    protected $primaryKey = 'setting_id';

    protected $casts = [
        'amount' => 'int'
    ];

    protected $fillable = [
        'amount'
    ];

    /**
     * 事業者金額設定
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function businessTippingAmountSettings()
    {
        return $this->hasMany(BusinessTippingAmountSetting::class, 'setting_id');
    }
}
