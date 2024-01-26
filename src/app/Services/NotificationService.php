<?php

namespace App\Services;

use App\Domain\Notification\NotificationList;
use App\Enums\EntityType;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Models\Notification;
use App\Models\PrivateNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * お知らせ・個人向けお知らせのリストを取得
     *
     * @param EntityType $entityType
     * @param int $entityId
     * @param int|null $limit
     * @return NotificationList
     */
    public function list(EntityType $entityType, int $entityId, int $limit = null): NotificationList
    {
        return new NotificationList($entityType, $entityId, $limit);
    }

    /**
     * お知らせ詳細の表示処理
     *
     * @param int $notificationId
     * @param EntityType $entityType
     * @param int $entityId
     */
    public function show(int $notificationId, EntityType $entityType, int $entityId): Notification
    {
        // お知らせ既読更新
        $this->createRead($notificationId, $entityType, $entityId);

        // お知らせ詳細情報取得
        $notification = Notification::find($notificationId);

        return $notification;
    }

    /**
     * 個人向けお知らせ詳細の表示処理
     *
     * @param int $notificationId
     */
    public function showPrivate(int $notificationId)
    {
        // 個人向けお知らせ既読更新
        $this->updatePrivateRead($notificationId);

        // 個人向けお知らせ詳細情報取得
        $privateNotification = PrivateNotification::find($notificationId);

        return $privateNotification;
    }

    /**
     * お知らせ既読更新
     *
     * @param int $notificationId
     * @param EntityType $entityType
     * @param int $entityId
     */
    private function createRead(int $notificationId, EntityType $entityType, int $entityId)
    {
        $this->notificationRepository->createRead($notificationId, $entityType, $entityId);

        return;
    }

    /**
     * 個人向けお知らせ既読更新
     *
     * @param int $notificationId
     */
    private function updatePrivateRead(int $notificationId)
    {
        $this->notificationRepository->updatePrivateRead($notificationId);

        return;
    }

    /**
     * お知らせPDF取得
     *
     * @param int $notificationId
     * @return string $path
     */
    public function pdf(int $notificationId, EntityType $entityType, int $entityId): string
    {
        $notification = Notification::find($notificationId);

        $path = "http://192.168.80.32:8080/storage/pdf/" . $notification->file_name . '.' . $notification->file_type;

        // お知らせ既読更新
        $this->createRead($notificationId, $entityType, $entityId);

        return $path;
    }
}
