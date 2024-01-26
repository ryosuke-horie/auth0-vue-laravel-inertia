<?php

namespace App\Domain\PointHistory\Items;

use App\Enums\TransactionType;

class PointHistoryListItem
{
    public readonly int $transactionType;
    public readonly float $pointChange;
    public readonly string $createdAt;

    public function __construct(
        int $transactionType,
        float $pointChange,
        string $createdAt,
    ) {
        $this->transactionType = $transactionType;
        $this->pointChange     = $this->calcPointChange($transactionType, $pointChange);
        $this->createdAt       = $createdAt;
    }

    private function calcPointChange(int $transactionType, float $pointChange): float
    {
        if ($transactionType === TransactionType::exChange->value) {
            return -$pointChange;
        }

        return $pointChange;
    }
}
