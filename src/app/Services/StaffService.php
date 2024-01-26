<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\EntityType;
use App\Mail\RegisterAdminStaffMail;
use App\Mail\RegisterStaffMail;
use App\Repositories\Staff\StaffRepositoryInterface;
use App\Repositories\StaffNotification\StaffNotificationRepositoryInterface;
use App\Repositories\Token\TokenRepositoryInterface;
use App\Trais\FileTrait;
use App\Trais\TokenTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class StaffService
{
    use FileTrait;
    use TokenTrait;

    private StaffRepositoryInterface $staffRepository;
    private StaffNotificationRepositoryInterface $staffNotificationRepository;
    private TokenRepositoryInterface $tokenRepository;

    public function __construct(
        StaffRepositoryInterface $staffRepository,
        StaffNotificationRepositoryInterface $staffNotificationRepository,
        TokenRepositoryInterface $tokenRepository
    ) {
        $this->staffRepository = $staffRepository;
        $this->staffNotificationRepository = $staffNotificationRepository;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * スタッフデータ取得
     */
    public function getStaff(int $staffId): array
    {
        $staff = $this->staffRepository->findByStaffId($staffId);

        return [
            'favorites' => $staff->staffFavorites->count(),
            'points' => $staff->points,
            'staffName' => $staff->staff_name,
            'businessName' => $staff->businessOperator->business_name,
        ];
    }

    /**
     * スタッフプロフィールデータ取得
     * @param int $staffId
     * @return array $args
     */
    public function getProfile(int $staffId): array
    {
        $staff = $this->staffRepository->findByStaffId($staffId);

        $images = $staff->staffProfileImages->map(function ($image) {
            return [
                'image' => $this->getFileUrl($image->file_name, $image->file_type),
                'order' => $image->order
            ];
        });

        $args = [
            'staffId'   => $staffId,
            'images'    => $images,
            'staffName' => $staff->staff_name,
            'comment'   => $staff->comment,
        ];

        return $args;
    }

    /**
     * プロフィール更新処理
     * @param int $staffId
     * @param Request $request
     */
    public function updateProfile(int $staffId, Request $request): void
    {
        $this->staffRepository->updateStaffProfile($staffId, $request->staffName, $request->comment);
    }

    /**
     * 各種設定取得
     * @param int $staffId
     * @return array $args
     */
    public function getSetting(int $staffId): array
    {
        $staffNotification = $this->staffRepository->findStaffNotificationByStaffId($staffId);

        $args = [
            'staffId'           => $staffId,
            'isMessageNotified' => $staffNotification->is_message_notified
        ];

        return $args;
    }

    /**
     * プロフィール画像追加・更新
     * @param int $staffId
     * @param Request $request
     * @return array $args
     */
    public function updateProfileImage(int $staffId, Request $request): array
    {
        $order = (int)$request->input('order');

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');

            $requestFile = $image->getClientOriginalName();
            $path        = $image->store('public/images/test');
            $fileName    = pathinfo($path, PATHINFO_FILENAME);
            $fileType    = pathinfo($requestFile, PATHINFO_EXTENSION);
            $fileSize    = $image->getSize();

            if ($this->checkImageFileType($fileType)) {
                $staffProfileImage = $this->staffRepository->findStaffProfileImageByStaffIdOrder($staffId, $order);
                if (is_null($staffProfileImage)) {
                    $this->staffRepository->createStaffProfileImage($staffId, $order, $fileName, $fileType, $fileSize);
                } else {
                    $this->deleteFile($staffProfileImage->file_name, $staffProfileImage->file_type);
                    $this->staffRepository->updateStaffProfileImage($staffId, $order, $fileName, $fileType, $fileSize);
                }
            }
        }

        return $this->getProfile($staffId);
    }

    /**
     * 各種設定取得
     * @param int $staffId
     * @param Request $request
     * @return array $args
     */
    public function deleteProfileImage(int $staffId, Request $request): array
    {
        $order = (int)$request->input('order');

        $staffProfileImage = $this->staffRepository->findStaffProfileImageByStaffIdOrder($staffId, $order);

        if (!is_null($staffProfileImage)) {
            $this->deleteFile($staffProfileImage->file_name, $staffProfileImage->file_type);
            $this->staffRepository->deleteStaffProfileImageByStaffIdOrder($staffId, $order);
        }

        return $this->getProfile($staffId);
    }

    /**
     * 事業者に紐づくスタッフを取得
     * @param int $businessId
     *
     */
    public function getStaffByBusinessId(int $businessId): Collection
    {
        $staffList = $this->staffRepository->getStaffByBusinessId($businessId);

        $newStaffList = $staffList->map(function ($staff) {

            $staffProfileImage = $this->staffRepository->findStaffProfileImageByStaffIdOrder($staff->staff_id, 1);

            return [
                'staffId'      => $staff->staff_id,
                'staffName'    => $staff->staff_name,
                'src'          => $this->getFileUrl($staffProfileImage->file_name ?? '', $staffProfileImage->file_type ?? '')
            ];
        });

        return $newStaffList;
    }


    /**
     * スタッフの削除処理
     * @param int $staffId
     */
    public function deleteStaff(int $staffId): void
    {
        $this->staffRepository->deleteStaff($staffId);
    }

    /**
     * スタッフスケジュール取得
     */
    public function getStaffSchedules(int $staffId)
    {
        $initSchedules = $this->staffRepository->getAllStaffScheduleByStaffId($staffId);
        $existSchedule = $initSchedules->map(function ($s) {
            return Carbon::parse($s->schedule_date)->format('Y/m/d');
        });

        $startDate = Carbon::today();
        for ($i = 0; $i < 14; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y/m/d');
            if (!$existSchedule->contains($date)) {
                $this->staffRepository->createStaffSchedule($staffId, $date);
            }
        }

        $latestSchedules = $this->staffRepository->getAllStaffScheduleByStaffId($staffId);
        $schedules = $latestSchedules->sortBy('schedule_date')->values()->map(function ($latestSchedule) {
            $date = Carbon::parse($latestSchedule->schedule_date);
            return [
                'id'        => $latestSchedule->schedule_id,
                'date'      => $date->format('m/d'),
                'dayOfWeek' => $date->format('l'),
                'status'    => $latestSchedule->shift_status,
            ];
        });

        $startDate = Carbon::parse($schedules[0]['date'])->format('Y年m月d日');
        $endDate = Carbon::parse($schedules[13]['date'])->format('Y年m月d日');

        $args = [
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'schedules' => $schedules
        ];

        return $args;
    }

    /**
     * スタッフスケジュール更新
     */
    public function updateStaffSchedules(int $staffId, array $data): void
    {
        DB::transaction(function () use ($staffId, $data) {
            foreach ($data as $item) {
                $scheduleId = $item['id'];
                $status = $item['status'];
                $this->staffRepository->updateStaffScheduleByScheduleIdStaffId($scheduleId, $staffId, $status);
            }
        });
    }

    /**
     * スタッフ登録用トークン追加orスタッフ追加
     */
    public function registerTokenForStaffs(int $businessId, array $staffs): void
    {
        foreach ($staffs as $item) {
            $email     = $item['email'];
            $staffName = $item['staffName'];
            if (!is_null($email)) {
                $token = $this->generateToken();
                $this->tokenRepository->registerToken($businessId, EntityType::BusinessOperator, $email, $token);
                Mail::to($email)->send(new RegisterStaffMail($staffName, $email, $token));
            } else {
                $this->staffRepository->createStaffNotEmail($businessId, $staffName);
            }
        }
    }

    /**
     * 管理者スタッフ登録用トークン追加
     *
     */
    public function registerTokenForAdminStaff(int $businessId, string $name, string $email, array $staffIds)
    {
        $token = $this->generateToken();
        $this->tokenRepository->registerToken($businessId, EntityType::BusinessOperator, $email, $token);
        Mail::to($email)->send(new RegisterAdminStaffMail($name, $email, $staffIds, $token));
    }

    /**
     * スタッフ登録
     * @param string $token
     * @param string $staffName
     * @param string $email
     * @param string $password
     */
    public function registerStaff(string $token, string $staffName, string $email, string $password)
    {
        $businessId = $this->tokenRepository->getBusinessIdByToken($token);
        if ($businessId) {
            $staff = $this->staffRepository->createStaff($businessId, $staffName, $email, $password);
            $this->staffNotificationRepository->createStaffNotification($staff->staff_id);
            $this->tokenRepository->deleteToken($token);
            return $staff;
        } else {
            return null;
        }
    }

    /**
     * スタッフメールアドレス更新
     * @param $staffId
     * @param $email
     * @return void
     */
    public function updateEmail(int $staffId, $email): void
    {
        $this->staffRepository->updateEmail($staffId, $email);
    }
}
