<?php

namespace App\Enums;

enum RequestStatus: int
{
    case Transferred = 1;
    case Pending = 2;
    case Cancel = 3;

    public function getName(): string
    {
        return match ($this) {
            self::Transferred => '振込済み',
            self::Pending => '未振込',
            self::Cancel => 'キャンセル',
        };
    }
}
