<?php

declare(strict_types=1);

namespace App\Repositories\AdminStaff;

use App\Models\AdminStaff;
use Illuminate\Support\Collection;

interface AdminStaffRepositoryInterface
{
    /**
     * 管理者スタッフ取得
     * @param int $adminStaffId
     * @return AdminStaff|null
     */
    public function findByAdminStaffId(int $adminStaffId): ?AdminStaff;

    /**
     * 管理者スタッフに紐づくスタッフ一覧を取得
     * @param int $adminStaffId
     * @return Collection
     */
    public function getAllStaffsByAdminStaffId(int $adminStaffId): Collection;

    /**
     * 事業者に紐づく管理者スタッフ一覧を取得
     * @param int $businessId
     * @return Collection
     */
    public function getAdminStaffsByBusinessId(int $businessId): Collection;

    /**
     * 管理者スタッフ登録
     * @param int $businessId
     * @param string $adminStaffName
     * @param string $email
     * @param string $password
     * @param array $staffIds
     * @return AdminStaff
     */
    public function createAdminStaff(int $businessId, string $adminStaffName, string $email, string $password, array $staffIds): AdminStaff;

    /**
     * 管理者スタッフ更新
     * @param int $adminStaffId
     * @param string $name
     * @return void
     */
    public function updateDetail(int $adminStaffId, string $name): void;

    /**
     * 管理者スタッフのメールアドレス更新
     * @param int $adminStaffId
     * @param string $email
     * @return void
     */
    public function updateEmail(int $adminStaffId, string $email): void;

    /**
     * 管理者スタッフ削除
     * @param int $adminStaffId
     */
    public function deleteByAdminStaffId(int $adminStaffId): void;

    /**
     * 中間テーブル追加
     * @param int $businessId
     * @param int $adminStaffId
     * @param array $staffIds
     * @return void
     */
    public function attachStaffs(int $businessId, int $adminStaffId, array $staffIds): void;

    /**
     * 中間テーブル削除
     * @param int $adminStaffId
     * @return void
     */
    public function detachStaffs(int $adminStaffId): void;
}
