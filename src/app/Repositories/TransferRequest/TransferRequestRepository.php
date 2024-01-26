<?php

namespace App\Repositories\TransferRequest;

use App\Models\TransferRequest;
use App\Models\TransferRequestCancellation;
use Illuminate\Support\Collection;
use App\Enums\EntityType;

class TransferRequestRepository implements TransferRequestRepositoryInterface
{
    public function getTransferRequestByEntity(EntityType $entityType, int $entityId): Collection
    {
        return TransferRequest::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->get();
    }

    public function getTransferRequestByRequestId(int $requestId): TransferRequest
    {
        return TransferRequest::find($requestId);
    }

    public function getListByEntityDate(EntityType $entityType, int $entityId, string $date): bool
    {
        return TransferRequest::where('entity_type', $entityType)
        ->where('entity_id', $entityId)
        ->where(function ($query) use ($date) {
            $query->where('transaction_period_from', '<=', $date)
            ->where('transaction_period_to', '>=', $date);
        })
        ->exists();
    }
}
