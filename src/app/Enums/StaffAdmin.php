<?php

namespace App\Enums;

enum EntityType: int
{
    case User = 1;
    case Staff = 2;
    case BusinessOperator = 3;
    case Corporation = 4;
}
