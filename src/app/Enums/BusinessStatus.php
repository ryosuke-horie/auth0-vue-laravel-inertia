<?php

namespace App\Enums;

// 口座種別
enum BusinessStatus: int
{
    case Up = 1;
    case Stop = 2;
    case Closed = 3;

    public function getName(): string
    {
        return match ($this) {
            self::Up => '稼働',
            self::Stop => '停止',
            self::Closed => '休業',
        };
    }
}
