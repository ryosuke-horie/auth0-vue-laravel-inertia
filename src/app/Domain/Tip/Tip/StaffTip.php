<?php

declare(strict_types=1);

namespace App\Domain\Tip\Tip;

class StaffTip
{
    public readonly int $replyId;
    public readonly ?string $image;
    public readonly string $createdAt;
    public readonly string $staffName;
    public readonly string $message;
    public readonly ?string $messageSrc;
    public readonly ?string $messageSrcType;

    public function __construct(
        int $replyId,
        ?string $image,
        string $createdAt,
        string $staffName,
        string $message,
        ?string $messageSrc,
        ?string $messageSrcType
    ) {
        $this->replyId        = $replyId;
        $this->image          = $image;
        $this->createdAt      = $createdAt;
        $this->staffName      = $staffName;
        $this->message        = $message;
        $this->messageSrc     = $messageSrc;
        $this->messageSrcType = $messageSrcType;
    }
}
