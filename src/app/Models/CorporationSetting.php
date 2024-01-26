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
 * @property int $corporation_id
 * @property bool $is_auto_apply
 * @property int $auto_apply_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Corporation $corporation
 *
 * @package App\Models
 */
class CorporationSetting extends Model
{
    protected $table = 'corporation_settings';
    protected $primaryKey = 'setting_id';

    protected $casts = [
        'corporation_id' => 'int',
        'is_auto_apply' => 'bool',
        'auto_apply_amount' => 'int'
    ];

    protected $fillable = [
        'corporation_id',
        'is_auto_apply',
        'auto_apply_amount'
    ];

    public function corporations()
    {
        return $this->belongsTo(Corporation::class);
    }
}
