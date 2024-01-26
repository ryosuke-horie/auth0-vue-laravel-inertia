<?php

namespace App\Enums;

enum ShiftStatus: int
{
    case Working = 1;
    case Off = 2;
    case Undecided = 3;

    public function getName(): string
    {
        return match ($this) {
            self::Working => '出勤',
            self::Off => '休み',
            self::Undecided => '未定',
        };
    }
}
