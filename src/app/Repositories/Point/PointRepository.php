<?php

namespace App\Repositories\Point;

use App\Models\PointBuyHistory;
use App\Models\PointDetail;
use App\Models\PointUsageHistory;
use Illuminate\Support\Collection;

class PointRepository implements PointRepositoryInterface
{
    public function getAllUsablePointDetailsByUserId(int $userId): Collection
    {
        $where = ['user_id' => $userId, 'is_point_usable' => true];
        return PointDetail::where($where)->orderBy('created_at', 'asc')->get();
    }

    public function updatePointDetails(int $detailId, int $remainingPoints, bool $isPointUsable): void
    {
        PointDetail::where('detail_id', $detailId)->update([
            'remaining_points' => $remainingPoints,
            'is_point_usable'  => $isPointUsable,
        ]);
    }

    public function createPointUsageHistory(int $detailId, int $userTipId, int $usedPoints): void
    {
        PointUsageHistory::create([
            'detail_id' => $detailId,
            'tip_id' => $userTipId,
            'used_points' => $usedPoints,
        ]);
    }
}
