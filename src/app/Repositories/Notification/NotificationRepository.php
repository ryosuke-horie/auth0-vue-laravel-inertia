<?php

namespace App\Repositories\Notification;

use App\Enums\EntityType;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\PrivateNotification;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * 全体お知らせ取得
     *
     * @param EntityType $entityType
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @return Collection
     */
    public function getNotification(EntityType $entityType, Carbon $startAt, Carbon $endAt): Collection
    {
        $data = Notification::where('entity_type', $entityType)
        ->where('start_at', '<=', $startAt)
        ->where(function ($query) use ($endAt) {
            $query->where('end_at', '>=', $endAt)
            ->orWhereNull('end_at');
        })
        ->with('notificationReads')
        ->get();

        return $data;
    }

    /**
     * 既読データ存在確認
     *
     * @param int $notificationId
     * @param EntityType $entityType
     * @param int $entityId
     * @return bool
     */
    public function hasReadRecord(int $notificationId, EntityType $entityType, int $entityId): bool
    {
        $bool = NotificationRead::where('notification_id', $notificationId)
        ->where('entity_type', $entityType)
        ->where('entity_id', $entityId)
        ->exists();

        return $bool;
    }

    /**
     * 個人お知らせ取得
     *
     * @param EntityType $entityType
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @return Collection
     */
    public function getPrivateNotification(EntityType $entityType, int $entityId, Carbon $startAt, Carbon $endAt): Collection
    {
        $data = PrivateNotification::where('entity_type', $entityType)
        ->where('entity_id', $entityId)
        ->where('start_at', '<=', $startAt)
        ->where(function ($query) use ($endAt) {
            $query->where('end_at', '>=', $endAt)
            ->orWhereNull('end_at');
        })
        ->get();

        return $data;
    }

    /**
     * お知らせ既読情報登録
     *
     * @param int $notificationId
     */
    public function createRead(int $notificationId, EntityType $entityType, int $entityId)
    {
        NotificationRead::firstOrCreate(
            [
                'notification_id'   => $notificationId,
                'entity_type'       => $entityType,
                'entity_id'         => $entityId
            ],
            [
                'notification_id'   => $notificationId,
                'entity_type'       => $entityType,
                'entity_id'         => $entityId
            ]
        );
    }

    /**
     * 個人向け既読情報更新
     *
     * @param int $notificationId
     */
    public function updatePrivateRead(int $notificationId)
    {
        $privateNotification = PrivateNotification::find($notificationId);

        $privateNotification->is_read = true;

        $privateNotification->save();
    }
}
