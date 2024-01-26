<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransferRequestCancellation
 *
 * @property int $request_cancel_id
 * @property int $request_id
 * @property string $cancel_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property TransferRequest $transfer_request
 *
 * @package App\Models
 */
class TransferRequestCancellation extends Model
{
    protected $table = 'transfer_request_cancellations';
    protected $primaryKey = 'request_cancel_id';

    protected $casts = [
        'request_id' => 'int'
    ];

    protected $fillable = [
        'request_id',
        'cancel_reason'
    ];

    public function transferRequest()
    {
        return $this->belongsTo(TransferRequest::class, 'request_id');
    }
}
