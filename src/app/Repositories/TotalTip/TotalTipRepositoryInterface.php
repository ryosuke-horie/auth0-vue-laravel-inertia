<?php

namespace App\Repositories\TotalTip;

use Illuminate\Support\Collection;
use App\Enums\EntityType;

interface TotalTipRepositoryInterface
{
    /**
     * 事業者の年月毎の獲得ポイントを取得
     * @param int $businessId
     * @return Collection
     */
    public function getYearMonthPointByBusiness(int $businessId): Collection;

    /**
     * 累計投げ銭を月ごとに作成・更新する
     *
     * @param EntityType $entityType
     * @param int $entityId
     * @param string $yearMonth
     * @return void
     */
    public function updateOrCreateTotalTip(EntityType $entityType, int $entityId, string $yearMonth, int $amont): void;
}
