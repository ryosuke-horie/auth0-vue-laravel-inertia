<?php

namespace App\Domain\Like\Items;

class LikeListItem
{
    public readonly string $userName;
    public readonly ?string $image;

    public function __construct(
        string $userName,
        ?string $image,
    ) {
        $this->userName = $userName;
        $this->image    = $image;
    }
}
