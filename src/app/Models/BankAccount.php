<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BankAccount
 *
 * @property int $account_id
 * @property int $entity_type
 * @property int $entity_id
 * @property string $bank_name
 * @property string $branch_name
 * @property string $account_type
 * @property string $account_number
 * @property string $account_holder_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BankAccount extends Model
{
    protected $table = 'bank_accounts';
    protected $primaryKey = 'account_id';

    protected $casts = [
        'entity_type' => 'int',
        'entity_id' => 'int'
    ];

    protected $fillable = [
        'entity_type',
        'entity_id',
        'bank_name',
        'branch_name',
        'account_type',
        'account_number',
        'account_holder_name'
    ];
}
