<?php

namespace App\Repositories\Point;

use Illuminate\Support\Collection;

interface PointRepositoryInterface
{
    /**
     * 利用可能なすべてのポイント詳細を取得
     *
     * @param int $userId ユーザーID
     * @return Collection
     */
    public function getAllUsablePointDetailsByUserId(int $userId): Collection;

    /**
     * ポイント詳細を更新
     *
     * @param int $detailId ポイント詳細ID
     * @param int $remainingPoints 残ポイント
     * @param bool $isPointUsable ポイント利用可能フラグ
     * @return void
     */
    public function updatePointDetails(int $detailId, int $remainingPoints, bool $isPointUsable): void;

    /**
     * ポイント利用履歴を作成
     *
     * @param int $detailId ポイント詳細ID
     * @param int $userTipId 投げ銭ID
     * @param int $usedPoints 利用ポイント
     * @return void
     */
    public function createPointUsageHistory(int $detailId, int $userTipId, int $usedPoints): void;
}
