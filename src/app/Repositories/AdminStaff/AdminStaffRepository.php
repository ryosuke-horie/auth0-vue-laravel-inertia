<?php

namespace App\Repositories\AdminStaff;

use App\Models\AdminStaff;
use App\Models\Staff;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class AdminStaffRepository implements AdminStaffRepositoryInterface
{
    public function findByAdminStaffId(int $adminStaffId): ?AdminStaff
    {
        return AdminStaff::with('staffs', 'staffs.staffProfileImages')->find($adminStaffId);
    }

    public function getAllStaffsByAdminStaffId(int $adminStaffId): Collection
    {
        return AdminStaff::find($adminStaffId)->staffs;
    }

    public function getAdminStaffsByBusinessId(int $businessId): Collection
    {
        $where = ['business_id' => $businessId];
        return AdminStaff::where($where)->get();
    }

    public function createAdminStaff(int $businessId, string $adminStaffName, string $email, string $password, array $staffIds): AdminStaff
    {
        $adminStaff = AdminStaff::create([
            'business_id' => $businessId,
            'name'  => $adminStaffName,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $this->attachStaffs($businessId, $adminStaff->admin_staff_id, $staffIds);

        return $adminStaff;
    }

    public function updateDetail(int $adminStaffId, string $name): void
    {
        $adminStaff = AdminStaff::find($adminStaffId);
        $adminStaff->name = $name;
        $adminStaff->save();
    }

    public function updateEmail(int $adminStaffId, string $email): void
    {
        $adminStaff = AdminStaff::find($adminStaffId);
        $adminStaff->email = $email;
        $adminStaff->save();
    }

    public function deleteByAdminStaffId(int $adminStaffId): void
    {
        AdminStaff::find($adminStaffId)->delete();
    }

    public function attachStaffs(int $businessId, int $adminStaffId, array $staffIds): void
    {
        $adminStaff = AdminStaff::find($adminStaffId);
        $staffs = Staff::where('business_id', $businessId)->whereIn('staff_id', $staffIds)->get();
        $adminStaff->staffs()->attach($staffs);
    }

    public function detachStaffs(int $adminStaffId): void
    {
        $adminStaff = AdminStaff::find($adminStaffId);
        $adminStaff->staffs()->detach();
    }
}
