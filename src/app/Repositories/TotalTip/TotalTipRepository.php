<?php

namespace App\Repositories\TotalTip;

use App\Models\TotalTip;
use App\Enums\EntityType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TotalTipRepository implements TotalTipRepositoryInterface
{
    public function getYearMonthPointByBusiness(int $businessId): Collection
    {
        return TotalTip::selectRaw('total_tips.year_month, sum(total_tips.total_amount) as total_amount')
        ->join('staff', 'total_tips.entity_id', 'staff.staff_id')
        ->join('business_operators', 'staff.business_id', 'business_operators.business_id')
        ->where('total_tips.entity_type', EntityType::Staff)
        ->where('business_operators.business_id', $businessId)
        ->groupBy('total_tips.year_month')
        ->orderBy('total_tips.year_month', 'DESC')
        ->get();
    }

    /**
     * 累計投げ銭を月ごとに作成・更新する
     *
     * @param  EntityType $entityType
     * @param  int        $entityId
     * @param  string     $yearMonth
     * @return void
     */
    public function updateOrCreateTotalTip(EntityType $entityType, int $entityId, string $yearMonth, int $amount): void
    {
        // レコードを検索し、存在しなければ新規作成
        $totalTip = TotalTip::updateOrCreate(
            [
                'entity_type' => $entityType,
                'entity_id'   => $entityId,
                'year_month'  => $yearMonth
            ],
            ['total_amount' => $amount]
        );

        // レコードが既に存在する場合は、total_amountを加算
        if ($totalTip->wasRecentlyCreated === false) {
            $totalTip->increment('total_amount', $amount);
        }
    }
}
