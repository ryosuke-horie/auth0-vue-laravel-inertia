<?php

declare(strict_types=1);

namespace App\Trais;

use Illuminate\Support\Str;

trait TokenTrait
{
    public function generateToken($length = 32)
    {
        return Str::random($length);
    }
}
