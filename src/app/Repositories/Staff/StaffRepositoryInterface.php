<?php

declare(strict_types=1);

namespace App\Repositories\Staff;

use App\Models\Staff;
use App\Models\StaffNotification;
use App\Models\StaffProfileImage;
use App\Models\StaffSchedule;
use App\Models\UserLike;
use Illuminate\Support\Collection;

interface StaffRepositoryInterface
{
    /**
     * スタッフ登録
     * @param int $businessId
     * @param string $staffName
     * @param string $email
     * @param string $password
     * @return Staff
     */
    public function createStaff(int $businessId, string $staffName, string $email, string $password): Staff;

    /**
     * スタッフ登録
     * @param int $businessId
     * @param string $staffName
     * @return Staff
     */
    public function createStaffNotEmail(int $businessId, string $staffName): Staff;

    /**
     * 事業者に紐づくスタッフID一覧を取得
     * @param int $businessId
     * @return Collection
     */
    public function getAllStaffsByBusinessId(int $businessId): Collection;

    /**
     * スタッフ取得
     *
     * @param int $staffId
     * @return ?Staff
     */
    public function findByStaffId(int $staffId): ?Staff;

    /**
     * メールアドレスに紐づくスタッフ取得
     */
    public function findByEmail(string $email): ?Staff;

    /**
     * メールアドレス変更
     * @param int $staffId
     * @param string $email
     * @return void
     */
    public function updateEmail(int $staffId, string $email): void;

    /**
     * スタッフ更新(スタッフ名・一言コメント)
     *
     * @param int $staffId
     * @return void
     */
    public function updateStaffProfile(int $staffId, string $staffName, ?string $comment): void;

    /**
     * スタッフ画像取得
     *
     * @param int $staffId
     * @param int $order
     * @return ?StaffProfileImage
     */
    public function findStaffProfileImageByStaffIdOrder(int $staffId, int $order): ?StaffProfileImage;

    /**
     * スタッフ画像追加
     * @param int $staffId
     * @param int $order
     * @param string $fileName
     * @param string $fileType
     * @param int $fileSize
     * @return StaffProfileImage
     */
    public function createStaffProfileImage(int $staffId, int $order, string $fileName, string $fileType, int $fileSize): StaffProfileImage;

    /**
     * スタッフ画像更新
     * @param int $staffId
     * @param int $order
     * @param string $fileName
     * @param string $fileType
     * @param int $fileSize
     * @return StaffProfileImage
     */
    public function updateStaffProfileImage(int $staffId, int $order, string $fileName, string $fileType, int $fileSize): StaffProfileImage;

    /**
     * スタッフ画像削除
     *
     * @param int $staffId
     * @param int $order
     * @return void
     */
    public function deleteStaffProfileImageByStaffIdOrder(int $staffId, int $order): void;

    /**
     * スタッフ通知取得
     *
     * @param int $staffId
     * @return ?StaffNotification
     */
    public function findStaffNotificationByStaffId(int $staffId): ?StaffNotification;

    /**
     * いいね取得
     */
    public function getAllUserLikeByStaffId(int $staffId): Collection;

    /**
     * 特定ユーザーのいいね取得
     *
     * @param int $userId
     * @param int $staffId
     * @return UserLike|null
     */
    public function findUserLikeByUserIdAndStaffId(int $userId, int $staffId): ?UserLike;

    /**
     * いいねの数を取得
     *
     * @param int $staffId
     * @return int
     */
    public function getUserLikesCountByStaffId(int $staffId): int;

    /**
     * 事業者に紐づくスタッフ取得
     *
     * @param int $businessId
     */
    public function getStaffByBusinessId(int $businessId): Collection;

    /**
     * スタッフ削除
     *
     * @param int $staffId
     */
    public function deleteStaff(int $staffId): void;

    /**
     * スタッフスケジュール取得
     * @param int $staffId
     * @return Collection
     */
    public function getAllStaffScheduleByStaffId(int $staffId): Collection;

    /**
     * スタッフスケジュール作成
     * @param int $staffId
     * @param string $date
     * @return void
     */
    public function createStaffSchedule(int $staffId, string $date): void;

    /**
     * スタッフスケジュール更新
     * @param int $scheduleId
     * @param int $staffId
     * @return void
     */
    public function updateStaffScheduleByScheduleIdStaffId(int $scheduleId, int $staffId, int $status): void;

    /**
     * chatGPT制限数減らす
     * @param int $staffId
     * @return void
     */
    public function decrementStaffAiCountByStaffId(int $staffId): void;

    /**
     * ChatGPT制限数リセット
     * @param int $staffId
     * @return void
     */
    public function resetStaffAiCountByStaffId(int $staffId): void;

    /**
     * 対象事業者所属スタッフの所持ポイント合計取得
     * @param int $businessId
     * @return int
     */
    public function getTotalPointByBusiness(int $businessId): int;

    /**
     * スタッフポイント更新
     * @param int $staffId
     * @param int $amount
     * @return void
     */
    public function updateStaffPointsByStaffId(int $staffId, int $amount): void;
}
