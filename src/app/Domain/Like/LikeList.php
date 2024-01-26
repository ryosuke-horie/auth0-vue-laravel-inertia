<?php

namespace App\Domain\Like;

use App\Domain\Like\Items\LikeListItem;
use Illuminate\Support\Collection;
use App\Models\UserLike;

class LikeList
{
    public Collection $list;

    public function __construct()
    {
        $this->list = collect();
    }

    public function pushList(LikeListItem $item)
    {
        $this->list->push($item);
    }

    public function getListCount(): int
    {
        return $this->list->count();
    }

    public function getList(): Collection
    {
        return $this->list;
    }
}
