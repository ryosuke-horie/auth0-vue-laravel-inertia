<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessApplication
 *
 * @property int $business_application_id
 * @property string $email
 * @property int|null $corporation_application_id
 * @property string|null $corporation_name
 * @property string|null $applicant_name
 * @property string|null $applicant_name_kana
 * @property string $business_name
 * @property string $zip_code
 * @property string $pref_code
 * @property string $city
 * @property string $phone
 * @property string|null $invoice_reg_num
 * @property string|null $business_form
 * @property string|null $notes
 * @property int $application_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property CorporationApplication|null $corporation_application
 * @property Collection|BusinessOperator[] $business_operators
 *
 * @package App\Models
 */
class BusinessApplication extends Model
{
    protected $table = 'business_applications';
    protected $primaryKey = 'business_application_id';

    protected $casts = [
        'corporation_application_id' => 'int',
        'application_status' => 'int'
    ];

    protected $fillable = [
        'email',
        'corporation_application_id',
        'corporation_name',
        'applicant_name',
        'applicant_name_kana',
        'business_name',
        'zip_code',
        'pref_code',
        'city',
        'phone',
        'invoice_reg_num',
        'business_form',
        'notes',
        'application_status'
    ];

    public function corporationApplication()
    {
        return $this->belongsTo(CorporationApplication::class);
    }

    public function businessOperators()
    {
        return $this->hasMany(BusinessOperator::class);
    }
}
