<?php

namespace App\Domain\UserTip;

use Illuminate\Support\Collection;

class UserTipUpdate
{
    /**
     * 無償ポイントと有償ポイントを減算する
     *
     * @param int $amount 減算する金額
     * @param int $freePoints ユーザーの無償ポイント
     * @param int $paidPoints ユーザーの有償ポイント
     * @return array 減算後の無償ポイントと有償ポイント
     */
    public function deductPoints(int $amount, int $freePoints, int $paidPoints): array
    {
        // 現在のユーザーの無償ポイントと有償ポイント
        $currentFreePoints = $freePoints;
        $currentPaidPoints = $paidPoints;

        // 無償ポイントから先に減らす
        if ($currentFreePoints >= $amount) {
            // 無償ポイントが足りる場合は、全額を無償ポイントから差し引く
            $freePoint = $currentFreePoints - $amount;
        } else {
            // 無償ポイントが不足する場合は、残りの金額を有償ポイントから差し引く
            $amountAfterFreePoints  = $amount - $currentFreePoints;
            $freePoint = 0;

            if ($currentPaidPoints >= $amountAfterFreePoints) {
                // 有償ポイントが残額をカバーできる場合
                $paidPoint = $currentPaidPoints - $amountAfterFreePoints;
            } else {
                // 有償ポイントも不足する場合はエラー処理が必要
                // 例: ポイント不足のメッセージを表示、処理を中断等
            }
        }

        return [
            'freePoint' => $freePoint,
            'paidPoint' => $paidPoint ?? 0,
        ];
    }

    /**
     * ユーザーのポイント詳細を更新し、減算したポイント情報を配列で返す
     *
     * @param Collection $pointDetails ポイント詳細のkor
     * @param int $amount 減算する金額
     * @return array 減算されたポイントの詳細
     */
    public function deductPointsFromDetails(Collection $pointDetails, int $amount): array
    {
        $deductedPoints = [];
        $remainingAmount = $amount;
        foreach ($pointDetails as $pointDetail) {
            if ($remainingAmount <= 0) {
                // 必要なamountがすでに減算されていれば終了
                break;
            }

            $deductibleAmount = min($remainingAmount, $pointDetail->remaining_points);
            $pointDetail->remaining_points -= $deductibleAmount;
            $remainingAmount -= $deductibleAmount;

            // 必要な情報を配列に保持
            $deductedPoints[] = [
                'detailId' => $pointDetail->detail_id,
                'deductedAmount' => $deductibleAmount,
                'remainingPoints' => $pointDetail->remaining_points,
                'isPointUsable' => $pointDetail->is_point_usable === 0 ? false : true,
            ];

            // 次のポイント詳細へ移行する前に、現在のポイントが0になっている場合は処理を続ける
        }

        return $deductedPoints;
    }
}
