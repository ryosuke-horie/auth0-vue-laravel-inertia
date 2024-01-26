<?php

declare(strict_types=1);

namespace App\Repositories\StaffReply;

use App\Models\StaffReply;
use App\Models\ReplyMedia;
use Carbon\Carbon;

class StaffReplyRepository implements StaffReplyRepositoryInterface
{
    public function findByStaffReplyId(int $staffReplyId): ?StaffReply
    {
        return StaffReply::find($staffReplyId);
    }

    public function createStaffReply(int $tipId, string $message): StaffReply
    {
        $staffReply = new StaffReply();
        $staffReply->tip_id = $tipId;
        $staffReply->message = $message;
        $staffReply->created_at = Carbon::now();
        $staffReply->save();
        return $staffReply;
    }

    public function deleteStaffReply(int $replyId): void
    {
        ReplyMedia::where('reply_id', $replyId)->delete();
        StaffReply::destroy($replyId);
    }

    public function createReplyMedia(int $replyId, string $fileName, string $fileType, int $fileSize, int $duration): ReplyMedia
    {
        $create = [
            'reply_id'  => $replyId,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'duration'  => $duration
        ];
        return ReplyMedia::create($create);
    }
}
