<?php

namespace App\Repositories\BankAccount;

use App\Enums\EntityType;
use App\Models\BankAccount;
use Illuminate\Support\Collection;

interface BankAccountRepositoryInterface
{
    /**
     * 口座情報取得
     * @param EntityType $entityType
     * @param int $entityId
     */
    public function getBankAccountByEntity(EntityType $entityType, int $entityId);

    /**
     * 口座情報登録
     * @param array $param
     */
    public function createBankAccount(array $param): void;

    /**
     * 口座情報更新
     * @param int $accountId
     * @param array $param
     */
    public function updateBankAccount(int $accountId, array $param): void;
}
