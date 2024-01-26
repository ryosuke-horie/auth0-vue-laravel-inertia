<?php

declare(strict_types=1);

namespace App\Repositories\UserTip;

use App\Models\UserTip;
use Illuminate\Support\Collection;

class UserTipRepository implements UserTipRepositoryInterface
{
    public function getAllByUserId(int $userId): Collection
    {
        return UserTip::where('user_id', $userId)->orderByDesc('created_at')->with(['staff', 'staff.staffProfileImages', 'staffReply'])->get();
    }

    public function getAllByStaffId(int $staffId): Collection
    {
        return UserTip::where('staff_id', $staffId)->orderByDesc('created_at')->with(['user', 'user.userProfileImage', 'staffReply'])->get();
    }

    public function getAllByStaffIds(array $staffIds): Collection
    {
        return UserTip::whereIn('staff_id', $staffIds)->orderByDesc('created_at')->with(['user', 'user.userProfileImage', 'staffReply'])->get();
    }

    public function findByTipId(int $tipId): ?UserTip
    {
        return UserTip::with(['user','user.userProfileImage', 'staffReply'])->find($tipId);
    }

    public function updateIsStaffReadByTipId(int $tipId): void
    {
        $userTip = UserTip::find($tipId);
        $userTip->is_staff_read = true;
        $userTip->save();
    }

    public function updateIsUserReadByTipId(int $tipId): void
    {
        $userTip = UserTip::find($tipId);
        $userTip->is_user_read = true;
        $userTip->save();
    }

    public function decrementAiCountByStaffIdTipId(int $tipId): void
    {
        $where = ['tip_id' => $tipId];
        $userTip = UserTip::where($where)->first();
        $userTip->ai_count = $userTip->ai_count - 1;
        $userTip->save();
    }

    public function createUserTip(int $staffId, int $userId, string|null $message, int $amount, int $deskNumber): int
    {
        $userTip = UserTip::create([
            'staff_id' => $staffId,
            'user_id' => $userId,
            'message' => $message,
            'tipping_amount' => $amount,
            'desk_number' => $deskNumber,
        ]);

        return $userTip->tip_id;
    }
}
