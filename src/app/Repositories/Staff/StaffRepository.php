<?php

namespace App\Repositories\Staff;

use App\Models\Staff;
use App\Models\StaffNotification;
use App\Models\StaffProfileImage;
use App\Models\StaffSchedule;
use App\Models\UserLike;
use App\Models\BusinessOperator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class StaffRepository implements StaffRepositoryInterface
{
    public function createStaff(int $businessId, string $staffName, string $email, string $password): Staff
    {
        return Staff::create([
            'business_id' => $businessId,
            'real_name'   => $staffName,
            'staff_name'  => $staffName,
            'email'       => $email,
            'password'    => Hash::make($password)
        ]);
    }

    public function createStaffNotEmail(int $businessId, string $staffName): Staff
    {
        return Staff::create([
            'business_id' => $businessId,
            'real_name'   => $staffName,
            'staff_name'  => $staffName,
        ]);
    }

    public function getAllStaffsByBusinessId(int $businessId): Collection
    {
        return Staff::where('business_id', $businessId)->get();
    }

    public function findByStaffId(int $staffId): ?Staff
    {
        return Staff::with(['staffProfileImages'])->find($staffId);
    }

    public function findByEmail(string $email): ?Staff
    {
        return Staff::where('email', $email)->first();
    }

    public function updateEmail(int $staffId, string $email): void
    {
        $staff = Staff::find($staffId);
        $staff->email = $email;
        $staff->save();
    }

    public function updateStaffProfile(int $staffId, string $staffName, ?string $comment): void
    {
        $staff = Staff::find($staffId);
        $staff->staff_name = $staffName;
        $staff->comment    = $comment;
        $staff->save();
    }

    public function findStaffProfileImageByStaffIdOrder(int $staffId, int $order): ?StaffProfileImage
    {
        $where = ['staff_id' => $staffId, 'order' => $order];
        return StaffProfileImage::where($where)->first();
    }

    public function createStaffProfileImage(int $staffId, int $order, string $fileName, string $fileType, int $fileSize): StaffProfileImage
    {
        $create = [
            'staff_id'  => $staffId,
            'order'     => $order,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize
        ];
        return StaffProfileImage::create($create);
    }

    public function updateStaffProfileImage(int $staffId, int $order, string $fileName, string $fileType, int $fileSize): StaffProfileImage
    {
        $where = ['staff_id' => $staffId, 'order' => $order];
        $staffProfileImage = StaffProfileImage::where($where)->first();
        $staffProfileImage->file_name = $fileName;
        $staffProfileImage->file_type = $fileType;
        $staffProfileImage->file_size = $fileSize;
        $staffProfileImage->save();
        return $staffProfileImage;
    }

    public function deleteStaffProfileImageByStaffIdOrder(int $staffId, int $order): void
    {
        $where = ['staff_id' => $staffId, 'order' => $order];
        StaffProfileImage::where($where)->delete();
    }

    public function findStaffNotificationByStaffId(int $staffId): ?StaffNotification
    {
        return StaffNotification::where('staff_id', $staffId)->first();
    }

    public function getAllUserLikeByStaffId(int $staffId): Collection
    {
        return UserLike::where('staff_id', $staffId)->orderByDesc('created_at')->with(['user','user.userProfileImage'])->get();
    }

    public function getUserLikesCountByStaffId(int $staffId): int
    {
        return UserLike::where('staff_id', $staffId)->count();
    }

    public function findUserLikeByUserIdAndStaffId(int $userId, int $staffId): ?UserLike
    {
        $where = ['user_id' => $userId, 'staff_id' => $staffId];
        return UserLike::where($where)->first();
    }

    public function getStaffByBusinessId(int $businessId): Collection
    {
        return Staff::where('business_id', $businessId)->with('staffProfileImages')->get();
    }

    public function deleteStaff(int $staffId): void
    {
        Staff::find($staffId)->delete();
    }

    public function getAllStaffScheduleByStaffId(int $staffId): Collection
    {
        $where = ['staff_id' => $staffId];
        return StaffSchedule::where($where)->orderBy('schedule_date', 'DESC')->take(14)->get();
    }

    public function createStaffSchedule(int $staffId, string $date): void
    {
        StaffSchedule::create([
            'staff_id'      => $staffId,
            'schedule_date' => $date,
            'shift_status'  => 1,
        ]);
    }

    public function updateStaffScheduleByScheduleIdStaffId(int $scheduleId, int $staffId, int $status): void
    {
        $where = ['schedule_id' => $scheduleId, 'staff_id' => $staffId];
        $staffSchedule = StaffSchedule::where($where)->first();
        $staffSchedule->shift_status = $status;
        $staffSchedule->save();
    }

    public function decrementStaffAiCountByStaffId(int $staffId): void
    {
        $staff = Staff::find($staffId);
        $staff->ai_count = $staff->ai_count - 1;
        $staff->save();
    }

    public function resetStaffAiCountByStaffId(int $staffId): void
    {
        $staff = Staff::find($staffId);
        $staff->ai_count = 3;
        $staff->save();
    }

    public function getTotalPointByBusiness(int $businessId): int
    {
        return Staff::select()
        ->where('business_id', $businessId)
        ->sum('points');
    }

    public function updateStaffPointsByStaffId(int $staffId, int $amount): void
    {
        $staff = Staff::find($staffId);
        $staff->points += $amount;
        $staff->save();
    }
}
