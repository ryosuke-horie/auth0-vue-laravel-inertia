<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransferRequest
 *
 * @property int $request_id
 * @property int $entity_type
 * @property int $entity_id
 * @property int $request_status
 * @property string $notification_number
 * @property float $transfer_request_amount
 * @property float $payment_fee_rate
 * @property float $usage_fee_rate
 * @property float $transfer_fee_amount
 * @property float $transfer_amount
 * @property string $transaction_period
 * @property string $confirm_bank_name
 * @property string $confirm_branch_name
 * @property string $confirm_account_type
 * @property string $confirm_account_number
 * @property string $confirm_account_holder_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|TransferRequestCancellation[] $transfer_request_cancellations
 *
 * @package App\Models
 */
class TransferRequest extends Model
{
    protected $table = 'transfer_requests';
    protected $primaryKey = 'request_id';

    protected $casts = [
        'entity_type' => 'int',
        'entity_id' => 'int',
        'request_status' => 'int',
        'transfer_request_amount' => 'float',
        'payment_fee_rate' => 'float',
        'usage_fee_rate' => 'float',
        'transfer_fee_amount' => 'float',
        'transfer_amount' => 'float'
    ];

    protected $fillable = [
        'entity_type',
        'entity_id',
        'request_status',
        'notification_number',
        'transfer_request_amount',
        'payment_fee_rate',
        'usage_fee_rate',
        'transfer_fee_amount',
        'transfer_amount',
        'transaction_period',
        'confirm_bank_name',
        'confirm_branch_name',
        'confirm_account_type',
        'confirm_account_number',
        'confirm_account_holder_name'
    ];

    public function transferRequestCancellations()
    {
        return $this->hasMany(TransferRequestCancellation::class, 'request_id');
    }
}
