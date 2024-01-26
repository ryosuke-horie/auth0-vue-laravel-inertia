<?php

namespace App\Repositories\Admin;

use App\Models\TippingAmountSetting;
use Illuminate\Support\Collection;

interface AdminRepositoryInterface
{
    /**
     * 投げ銭金額設定を全て取得
     *
     * @return Collection
     */
    public function getAllTippingAmountSetting(): Collection;
}
