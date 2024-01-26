<?php

namespace App\Services;

use App\Domain\Like\Items\LikeListItem;
use App\Domain\Like\LikeList;
use App\Repositories\Staff\StaffRepositoryInterface;
use App\Trais\FileTrait;

class LikeService
{
    use FileTrait;

    private $staffRepository;

    public function __construct(StaffRepositoryInterface $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function list(int $staffId)
    {
        $likeList = new LikeList();

        $userLikes = $this->staffRepository->getAllUserLikeByStaffId($staffId);
        foreach ($userLikes as $userLike) {
            $likeList->pushList(
                new LikeListItem(
                    $userLike->user->nickname,
                    $this->getFileUrl($userLike->user->userProfileImage->file_name ?? null, $userLike->user->userProfileImage->file_type ?? null),
                )
            );
        }

        $args = [
            'likeCount' => $likeList->getListCount(),
            'likeList'  => $likeList->getList(),
        ];

        return $args;
    }
}
