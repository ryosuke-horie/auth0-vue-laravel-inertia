<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\Tip\Tip\UserTip;
use App\Domain\Tip\Tip\StaffTip;
use App\Http\Requests\Staff\TipCreateReplyRequest;
use App\Repositories\AdminStaff\AdminStaffRepositoryInterface;
use App\Repositories\Staff\StaffRepositoryInterface;
use App\Repositories\StaffReply\StaffReplyRepositoryInterface;
use App\Repositories\UserTip\UserTipRepositoryInterface;
use App\Trais\FileTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TipService
{
    use FileTrait;

    private UserTipRepositoryInterface $userTipRepository;
    private StaffReplyRepositoryInterface $staffReplyRepository;
    private StaffRepositoryInterface $staffRepository;
    private AdminStaffRepositoryInterface $adminStaffRepository;

    public function __construct(
        UserTipRepositoryInterface $userTipRepository,
        StaffReplyRepositoryInterface $staffReplyRepository,
        StaffRepositoryInterface $staffRepository,
        AdminStaffRepositoryInterface $adminStaffRepository
    ) {
        $this->userTipRepository = $userTipRepository;
        $this->staffReplyRepository = $staffReplyRepository;
        $this->staffRepository = $staffRepository;
        $this->adminStaffRepository = $adminStaffRepository;
    }

    /**
     * 事業者IDに紐づくスタッフに対する応援履歴一覧取得
     *
     * @param int $businessId
     * @return array $args
     */
    public function listForBusiness(int $businessId): array
    {
        $staffs = $this->staffRepository->getAllStaffsByBusinessId($businessId);
        $staffIds = $staffs->pluck('staff_id')->toArray();
        $userTips = $this->userTipRepository->getAllByStaffIds($staffIds);
        return $this->list($userTips);
    }

    /**
     * 管理者スタッフIDに紐づくスタッフに対する応援履歴一覧取得
     *
     * @param int $adminStaffId
     * @return array $args
     */
    public function listForAdminStaff(int $adminStaffId): array
    {
        $staffs = $this->adminStaffRepository->getAllStaffsByAdminStaffId($adminStaffId);
        $staffIds = $staffs->pluck('staff_id')->toArray();
        $userTips = $this->userTipRepository->getAllByStaffIds($staffIds);
        return $this->list($userTips);
    }

    /**
     * 応援履歴一覧取得
     *
     * @param int $staffId
     * @return array $args
     */
    public function listForStaff(int $staffId): array
    {
        $userTips = $this->userTipRepository->getAllByStaffId($staffId);
        return $this->list($userTips);
    }

    private function list(Collection $userTips): array
    {
        $tipList = collect();
        foreach ($userTips as $tip) {
            $userProfileImage = $tip->user->userProfileImage;
            $tipList->push(
                new UserTip(
                    $tip->tip_id,
                    $this->getFileUrl($userProfileImage->file_name ?? null, $userProfileImage->file_type ?? null),
                    Carbon::parse($tip->created_at)->format('Y-m-d'),
                    $tip->user->nickname,
                    $tip->tipping_amount,
                    '',
                    $tip->is_staff_read,
                    !!$tip->staffReply
                )
            );
        }

        $args = [
            'userTips' => $tipList
        ];

        return $args;
    }

    /**
     * 応援履歴取得
     * @param int $tipId
     * @return array $args
     */
    public function show(int $tipId): array
    {
        $userTipRepo = $this->userTipRepository->findByTipId($tipId);
        $userProfileImage = $userTipRepo->user->userProfileImage;

        $userTip = new UserTip(
            $userTipRepo->tip_id,
            $this->getFileUrl($userProfileImage->file_name ?? null, $userProfileImage->file_type ?? null),
            Carbon::parse($userTipRepo->created_at)->format('Y-m-d'),
            $userTipRepo->user->nickname,
            $userTipRepo->tipping_amount,
            $userTipRepo->message,
            false,
            false
        );

        $staffTipReply = null;
        if (!is_null($userTipRepo->staffReply)) {
            $staffProfileImage = $userTipRepo->staff->staffProfileImages->first();
            $staffTipReply = new StaffTip(
                $userTipRepo->staffReply->reply_id,
                $this->getFileUrl($staffProfileImage->file_name ?? null, $staffProfileImage->file_type ?? null),
                Carbon::parse($userTipRepo->staffReply->created_at)->format('Y-m-d'),
                $userTipRepo->staff->staff_name,
                $userTipRepo->staffReply->message,
                $this->getFileUrl($userTipRepo->staffReply->replyMedia->file_name ?? null, $userTipRepo->staffReply->replyMedia->file_type ?? null),
                $this->getFileType($userTipRepo->staffReply->replyMedia->file_type ?? null),
            );
        }

        $this->userTipRepository->updateIsStaffReadByTipId($tipId);

        $args = [
            'aiCount'       => $userTipRepo->ai_count,
            'userTip'       => $userTip,
            'staffTipReply' => $staffTipReply
        ];

        return $args;
    }

    /**
     * 応援履歴スタッフ返信
     *
     * @param int $tipId
     * @param TipCreateReplyRequest $request
     * @return void
     */
    public function createStaffReply(int $tipId, TipCreateReplyRequest $request): void
    {
        $message = $request->input('message');

        $staffReply = $this->staffReplyRepository->createStaffReply($tipId, $message);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');

            $requestFile = $file->getClientOriginalName();
            $path        = $file->store('public/images/test');
            $fileName    = pathinfo($path, PATHINFO_FILENAME);
            $fileType    = pathinfo($requestFile, PATHINFO_EXTENSION);
            $fileSize    = $file->getSize();
            $duration    = 30; // TODO 動画の長さ取得

            if ($this->checkFileType($fileType)) {
                $this->saveFile($fileName, $fileType);
                $this->staffReplyRepository->createReplyMedia($staffReply->reply_id, $fileName, $fileType, $fileSize, $duration);
            }
        }
    }

    /**
     * スタッフ返信削除
     *
     * @param int $replyId
     * @return void
     */
    public function deleteStaffReply(int $replyId): void
    {
        $this->staffReplyRepository->deleteStaffReply($replyId);
    }
}
