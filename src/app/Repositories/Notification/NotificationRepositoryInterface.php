<?php

namespace App\Repositories\Notification;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Enums\EntityType;

interface NotificationRepositoryInterface
{
    /**
     * 全体お知らせ取得
     *
     * @param EntityType $entityType
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @return Collection
     */
    public function getNotification(EntityType $entityType, Carbon $startAt, Carbon $endAt): Collection;

    /**
     * 既読情報取得
     *
     * @param int $notificationId
     * @param EntityType $entityType
     * @param int $entityId
     * @return bool
     */
    public function hasReadRecord(int $notificationId, EntityType $entityType, int $entityId): bool;

    /**
     * 個人お知らせ取得
     *
     * @param EntityType $entityType
     * @param int $entityId
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @return Collection
     */
    public function getPrivateNotification(EntityType $entityType, int $entityId, Carbon $startAt, Carbon $endAt): Collection;

    /**
     * 既読情報登録
     *
     * @param int $notificationId
     * @param EntityType $entityType
     * @param int $entityId
     */
    public function createRead(int $notificationId, EntityType $entityType, int $entityId);

    /**
     * 個人向け既読情報更新
     *
     * @param int $notificationId
     */
    public function updatePrivateRead(int $notificationId);
}
