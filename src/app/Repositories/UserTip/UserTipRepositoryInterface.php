<?php

namespace App\Repositories\UserTip;

use App\Models\UserTip;
use Illuminate\Support\Collection;

interface UserTipRepositoryInterface
{
    /**
     * 投げ銭情報一覧取得
     * @param int $userId
     * @return Collection
     */
    public function getAllByUserId(int $userId): Collection;

    /**
     * 投げ銭情報一覧取得
     * @param int $staffId
     * @return Collection
     */
    public function getAllByStaffId(int $staffId): Collection;

    /**
     * 投げ銭情報一覧取得
     * @param array $staffIds
     * @return Collection
     */
    public function getAllByStaffIds(array $staffIds): Collection;

    /**
     * 投げ銭情報取得
     * @param int $tipId
     * @return ?UserTip
     */
    public function findByTipId(int $tipId): ?UserTip;

    /**
     * スタッフ既読更新
     * @param int $tipId
     * @return void
     */
    public function updateIsStaffReadByTipId(int $tipId): void;

    /**
     * スタッフ既読更新
     * @param int $tipId
     * @return void
     */
    public function updateIsUserReadByTipId(int $tipId): void;

    /**
     * chatGPT制限数減らす
     * @param int $tipId
     * @return void
     */
    public function decrementAiCountByStaffIdTipId(int $tipId): void;

    /**
     * 投げ銭登録
     *
     * @param  int    $staffId スタッフのID
     * @param  int    $userId  ユーザーのID
     * @param  string|null $message ユーザーからのメッセージ
     * @param  int    $amount  チップの金額
     * @param  int    $deskNumber 卓番号
     * @return int    $userTip->tip_id; 投げ銭ID
     */
    public function createUserTip(int $staffId, int $userId, string|null $message, int $amount, int $deskNumber): int;
}
