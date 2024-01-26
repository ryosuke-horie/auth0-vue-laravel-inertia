<?php

namespace App\Repositories\BankAccount;

use App\Models\BankAccount;
use App\Enums\EntityType;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    public function getBankAccountByEntity(EntityType $entityType, int $entityId)
    {
        $bankAccount = BankAccount::where('entity_type', $entityType)
        ->where('entity_id', $entityId)
        ->first();

        return $bankAccount;
    }

    public function createBankAccount(array $param): void
    {
        BankAccount::create($param);
    }

    public function updateBankAccount(int $accountId, array $param): void
    {
        $bankAccount = BankAccount::find($accountId);
        $bankAccount->fill($param);
        $bankAccount->save();
    }
}
