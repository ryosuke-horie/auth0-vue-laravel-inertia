<?php

namespace App\Enums;

// 口座種別
enum AccountType: int
{
    case Normal = 1;  // 普通預金口座
    case Current = 2; // 当座預金口座

    public function getName(): string
    {
        return match ($this) {
            self::Normal => '普通預金口座',
            self::Current => '当座預金口座',
        };
    }
}
