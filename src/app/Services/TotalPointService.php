<?php

namespace App\Services;

use App\Enums\EntityType;
use App\Repositories\TotalTip\TotalTipRepositoryInterface;
use App\Repositories\Staff\StaffRepositoryInterface;
use App\Repositories\TransferRequest\TransferRequestRepositoryInterface;
use Carbon\Carbon;

class TotalPointService
{
    private StaffRepositoryInterface $staffRepositoryInterface;
    private TotalTipRepositoryInterface $totalTipRepositoryInterface;
    private TransferRequestRepositoryInterface $transferRequestRepositoryInterface;

    public function __construct(
        StaffRepositoryInterface $staffRepositoryInterface,
        TotalTipRepositoryInterface $totalTipRepositoryInterface,
        TransferRequestRepositoryInterface $transferRequestRepositoryInterface
    ) {
        $this->staffRepositoryInterface = $staffRepositoryInterface;
        $this->totalTipRepositoryInterface = $totalTipRepositoryInterface;
        $this->transferRequestRepositoryInterface = $transferRequestRepositoryInterface;
    }

    /**
     * 事業者ポイント集計一覧用データ取得
     */
    public function businessOperatorTotalPoint(int $businessId)
    {
        $args = [];

        // 未交換ポイント取得
        $args['totalPoint'] = $this->staffRepositoryInterface->getTotalPointByBusiness($businessId);

        // 年月毎のポイント取得
        $args['yearMonthList'] = $this->totalTipRepositoryInterface->getYearMonthPointByBusiness($businessId);

        // 交換済みかチェック
        $args['yearMonthList'] = $args['yearMonthList']->map(function ($yearMonth) use ($businessId) {
            return [
                'yearMonth'     => Carbon::parse($yearMonth->year_month)->format('Y年m月'),
                'totalAmount'  => number_format($yearMonth->total_amount),
                'isExchange'    => $this->transferRequestRepositoryInterface->getListByEntityDate(EntityType::BusinessOperator, $businessId, $yearMonth->year_month)

            ];
        });

        return $args;
    }
}
