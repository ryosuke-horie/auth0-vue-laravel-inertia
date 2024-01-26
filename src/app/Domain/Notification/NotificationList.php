<?php

namespace App\Domain\Notification;

use App\Domain\Notification\Items\NotificationListItem;
use App\Enums\EntityType;
use App\Models\Notification;
use App\Models\PrivateNotification;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Repositories\Notification\NotificationRepository;

/**
 * お知らせ一覧取得モデル
 */
class NotificationList
{
    private readonly Carbon $nowDate;
    private readonly EntityType $entityType;
    private readonly int $entityId;
    private readonly ?int $limit;

    private Collection $list;

    private NotificationRepository $notificationRepository;

    public function __construct(EntityType $entityType, int $entityId, ?int $limit = null)
    {
        $this->notificationRepository = app(NotificationRepository::class);

        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->limit = $limit;
        $this->nowDate = Carbon::now();

        $this->list = collect();
        $this->pushNotifications();
        $this->pushPrivateNotifications();
    }


    /**
     * お知らせ
     */
    private function pushNotifications()
    {
        $notifications = $this->notificationRepository->getNotification($this->entityType, $this->nowDate, $this->nowDate);
        foreach ($notifications as $notification) {
            $this->list->push(new NotificationListItem(
                $notification->notification_id,
                $notification->title,
                $notification->content,
                $notification->start_at->format('Y-m-d'),
                $this->notificationRepository->hasReadRecord($notification->notification_id, $this->entityType, $this->entityId),
                $notification->file_type,
                $notification->file_name,
                $notification->file_size,
                false
            ));
        };
    }

    /**
     * 個人向けお知らせ
     */
    private function pushPrivateNotifications()
    {
        $privateNotifications = $this->notificationRepository->getPrivateNotification($this->entityType, $this->entityId, $this->nowDate, $this->nowDate);

        foreach ($privateNotifications as $notification) {
            $this->list->push(new NotificationListItem(
                $notification->notification_id,
                $notification->title,
                $notification->content,
                $notification->start_at->format('Y-m-d'),
                $notification->is_read,
                null,
                null,
                null,
                true
            ));
        }
    }

    public function pushList(NotificationListItem $item): void
    {
        $this->list->push($item);
    }

    public function getList(): Collection
    {
        $notificationList = $this->list->sortByDesc('startAt')->values();

        if (is_null($this->limit)) {
            return $notificationList;
        }
        return $notificationList->slice(0, $this->limit);
    }
}
