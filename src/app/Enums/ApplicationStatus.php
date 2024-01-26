<?php

namespace App\Enums;

enum ApplicationStatus: int
{
    case Review = 1;
    case Approval = 2;
    case Denial = 3;

    public function getName(): string
    {
        return match ($this) {
            self::Review => '審査中',
            self::Approval => '許可',
            self::Denial => '否認',
        };
    }
}
