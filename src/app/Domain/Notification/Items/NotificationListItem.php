<?php

namespace App\Domain\Notification\Items;

class NotificationListItem
{
    public readonly int $notificationId;
    public readonly string $title;
    public readonly string $content;
    public readonly string $startAt;
    public readonly bool $isRead;
    public readonly ?string $fileType;
    public readonly ?string $fileName;
    public readonly ?int $fileSize;
    public readonly bool $privateFlag;

    public function __construct(
        int $notificationId,
        string $title,
        string $content,
        string $startAt,
        bool $isRead,
        ?string $fileType,
        ?string $fileName,
        ?int $fileSize,
        bool $privateFlag
    ) {
        $this->notificationId = $notificationId;
        $this->title = $title;
        $this->content = $content;
        $this->startAt = $startAt;
        $this->isRead = $isRead;
        $this->fileType = $fileType;
        $this->fileName = $fileName;
        $this->fileSize = $fileSize;
        $this->privateFlag = $privateFlag;
    }
}
