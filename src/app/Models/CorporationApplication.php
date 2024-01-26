<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CorporationApplication
 *
 * @property int $corporation_application_id
 * @property string $email
 * @property string $corporation_name
 * @property string $applicant_name
 * @property string $applicant_name_kana
 * @property string $zip_code
 * @property string $pref_code
 * @property string $city
 * @property string $phone
 * @property string $invoice_reg_num
 * @property int $application_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|BusinessApplication[] $business_applications
 * @property Collection|Corporation[] $corporations
 *
 * @package App\Models
 */
class CorporationApplication extends Model
{
    protected $table = 'corporation_applications';
    protected $primaryKey = 'corporation_application_id';

    protected $casts = [
        'application_status' => 'int'
    ];

    protected $fillable = [
        'email',
        'corporation_name',
        'applicant_name',
        'applicant_name_kana',
        'zip_code',
        'pref_code',
        'city',
        'phone',
        'invoice_reg_num',
        'application_status'
    ];

    public function businessApplications()
    {
        return $this->hasMany(BusinessApplication::class);
    }

    public function corporations()
    {
        return $this->hasMany(Corporation::class);
    }
}
