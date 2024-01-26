<?php

namespace App\Enums;

enum EntityType: int
{
    case User = 1;
    case Staff = 2;
    case BusinessOperator = 3;
    case Corporation = 4;

    public function getName(): string
    {
        return match ($this) {
            self::User => '投げ銭ユーザー',
            self::Staff => 'スタッフ',
            self::BusinessOperator => '事業者',
            self::Corporation => '法人',
        };
    }
}
