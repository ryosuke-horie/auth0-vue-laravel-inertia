<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EntityType;
use App\Mail\RegisterAdminStaffMail;
use App\Models\AdminStaff;
use App\Repositories\AdminStaff\AdminStaffRepositoryInterface;
use App\Repositories\Staff\StaffRepositoryInterface;
use App\Repositories\Token\TokenRepositoryInterface;
use App\Trais\FileTrait;
use App\Trais\TokenTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

class AdminStaffService
{
    use FileTrait;
    use TokenTrait;

    private AdminStaffRepositoryInterface $adminStaffRepository;
    private StaffRepositoryInterface $staffRepository;
    private TokenRepositoryInterface $tokenRepository;

    public function __construct(
        AdminStaffRepositoryInterface $adminStaffRepository,
        StaffRepositoryInterface $staffRepository,
        TokenRepositoryInterface $tokenRepository
    ) {
        $this->adminStaffRepository = $adminStaffRepository;
        $this->staffRepository = $staffRepository;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * 管理者スタッフ一覧取得
     * @param int $businessId
     * @return Collection
     */
    public function list(int $businessId): Collection
    {
        $adminStaffs = $this->adminStaffRepository->getAdminStaffsByBusinessId($businessId);

        $newStaffList = $adminStaffs->map(function ($adminStaff) {
            return [
                'adminStaffId' => $adminStaff->admin_staff_id,
                'name'         => $adminStaff->name,
            ];
        });

        return $newStaffList;
    }

    /**
     * 管理者スタッフ詳細取得
     * @param int $businessId
     * @param int $adminStaffId
     * @return array
     */
    public function detail(int $businessId, int $adminStaffId): array
    {
        $adminStaff = $this->adminStaffRepository->findByAdminStaffId($adminStaffId);

        $staffList = $this->staffRepository->getStaffByBusinessId($businessId);
        $newStaffList = $staffList->map(function ($staff) {
            $staffProfileImage = $this->staffRepository->findStaffProfileImageByStaffIdOrder($staff->staff_id, 1);
            return [
                'staffId'      => $staff->staff_id,
                'staffName'    => $staff->staff_name,
                'src'          => $this->getFileUrl($staffProfileImage->file_name ?? '', $staffProfileImage->file_type ?? '')
            ];
        });

        $args = [
            'adminStaffId'      => $adminStaff->admin_staff_id,
            'name'              => $adminStaff->name,
            'connectedStaffIds' => $adminStaff->staffs->pluck('staff_id'),
            'staffList'         => $newStaffList,
        ];

        return $args;
    }

    /**
     * 管理者スタッフ詳細更新
     * @param int $businessId
     * @param int $adminStaffId
     * @param string $name
     * @param array $staffIds
     * @return void
     */
    public function update(int $businessId, int $adminStaffId, string $name, array $staffIds): void
    {
        $this->adminStaffRepository->updateDetail($adminStaffId, $name);
        $this->adminStaffRepository->detachStaffs($adminStaffId);
        $this->adminStaffRepository->attachStaffs($businessId, $adminStaffId, $staffIds);
    }

    /**
     * 管理者スタッフメールアドレス更新
     * @param int $adminStaffId
     * @param string $email
     * @return void
     */
    public function updateEmail(int $adminStaffId, string $email): void
    {
        $this->adminStaffRepository->updateEmail($adminStaffId, $email);
    }

    /**
     * 管理者スタッフ削除
     * @param int $adminStaffId
     * @return void
     */
    public function delete(int $adminStaffId): void
    {
        $this->adminStaffRepository->deleteByAdminStaffId($adminStaffId);
    }

    /**
     * 管理者スタッフトークン登録
     * @param int $businessId
     * @param string $name
     * @param array $staffIds
     * @return void
     */
    public function registerToken(int $businessId, string $name, string $email, array $staffIds): void
    {
        $token = $this->generateToken();
        $this->tokenRepository->registerToken($businessId, EntityType::BusinessOperator, $email, $token);
        Mail::to($email)->send(new RegisterAdminStaffMail($name, $email, $staffIds, $token));
    }

    /**
     * 管理者スタッフ登録
     */
    public function registerAdminStaff(string $token, string $staffName, string $email, array $staffIds, string $password)
    {
        $businessId = $this->tokenRepository->getBusinessIdByToken($token);
        if ($businessId) {
            $adminStaff = $this->adminStaffRepository->createAdminStaff($businessId, $staffName, $email, $password, $staffIds);
            $this->tokenRepository->deleteToken($token);
            return $adminStaff;
        } else {
            // TODO:トークン管理に紐づくものがない場合の処理
            return null;
        }
    }
}
