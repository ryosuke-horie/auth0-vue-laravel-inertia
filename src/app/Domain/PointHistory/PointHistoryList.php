<?php

namespace App\Domain\PointHistory;

use App\Domain\PointHistory\Items\PointHistoryListItem;
use App\Enums\EntityType;
use Illuminate\Support\Collection;
use App\Models\PointFluctuationHistory;

class PointHistoryList
{
    private readonly EntityType $entityType;
    private readonly int $entityId;

    private Collection $list;

    public function __construct(EntityType $entityType, int $entityId)
    {
        $this->entityType = $entityType;
        $this->entityId = $entityId;

        $this->list = collect();

        $this->pushPointHistory();
    }

    /**
     * ポイント変動履歴
     */
    private function pushPointHistory()
    {
        $pointFluctuationHistoryWhere = [
            ['entity_id', '=', $this->entityId],
            ['entity_type', '=', $this->entityType],
        ];
        $pointFluctuationHistory = PointFluctuationHistory::where($pointFluctuationHistoryWhere)->get();
        foreach ($pointFluctuationHistory as $history) {
            $this->list->push(new PointHistoryListItem(
                $history->transaction_type,
                $history->point_change,
                $history->created_at
            ));
        }
    }

    public function getList(): Collection
    {
        return $this->list->sortByDesc('createdAt')->values();
    }
}
