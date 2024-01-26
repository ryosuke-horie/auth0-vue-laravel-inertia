<?php

namespace App\Repositories\PointFluctuationHistory;

use App\Enums\EntityType;

interface PointFluctuationHistoryRepositoryInterface
{
    /**
     * ポイント変動履歴を作成
     *
     * @param int $entityId エンティティID
     * @param EntityType $entityType エンティティタイプ
     * @param int $point ポイント
     * @param int $transactionType 取引タイプ
     * @return void
     */
    public function createPointFluctuationHistory(int $entityId, EntityType $entityType, int $point, int $transactionType): void;
}
