<?php

declare(strict_types=1);

namespace App\Repositories\StaffReply;

use App\Models\ReplyMedia;
use App\Models\StaffReply;

interface StaffReplyRepositoryInterface
{
    /**
     * スタッフ返信取得
     * @param int $staffReplyId
     */
    public function findByStaffReplyId(int $staffReplyId): ?StaffReply;

    /**
     * スタッフ返信追加
     */
    public function createStaffReply(int $tipId, string $message): StaffReply;

    /**
     * スタッフ返信メディア追加
     */
    public function createReplyMedia(int $replyId, string $fileName, string $fileType, int $fileSize, int $duration): ReplyMedia;

    /**
     * スタッフ返信・返信メディア削除
     */
    public function deleteStaffReply(int $replyId): void;
}
