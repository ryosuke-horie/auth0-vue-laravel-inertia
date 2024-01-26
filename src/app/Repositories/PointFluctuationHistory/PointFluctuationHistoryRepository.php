<?php

namespace App\Repositories\PointFluctuationHistory;

use App\Models\PointFluctuationHistory;
use App\Enums\EntityType;
use App\Enums\TransactionType;

class PointFluctuationHistoryRepository implements PointFluctuationHistoryRepositoryInterface
{
    public function createPointFluctuationHistory(int $entityId, EntityType $entityType, int $point, int $transactionType): void
    {
        PointFluctuationHistory::create([
            'entity_type'      => $entityType,
            'entity_id'        => $entityId,
            'point_change'     => $point,
            'transaction_type' => $transactionType,
        ]);
    }
}
