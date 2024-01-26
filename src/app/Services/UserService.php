<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Staff\StaffRepositoryInterface;
use App\Repositories\BusinessOperator\BusinessOperatorRepositoryInterface;
use App\Trais\FileTrait;
use App\Models\BusinessReview;

class UserService
{
    use FileTrait;

    protected $userRepository;
    protected $staffRepository;
    protected $businessOperatorRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        StaffRepositoryInterface $staffRepository,
        BusinessOperatorRepositoryInterface $businessOperatorRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->staffRepository = $staffRepository;
        $this->businessOperatorRepository = $businessOperatorRepository;
    }

    /**
     * ユーザー情報取得
     *
     * @param int $userId
     * @return array
     */
    public function getUserProfileImage(int $userId): array
    {
        $userProfile = $this->userRepository->getUserProfileImageByUserId($userId);
        $userProfileImage = $this->getFileUrl($userProfile->userProfileImage->file_name, $userProfile->userProfileImage->file_type);

        $args = [
            'userId'   => $userProfile->user_id,
            'nickname' => $userProfile->nickname,
            'userProfileImage' => $userProfileImage,
        ];

        return $args;
    }

    /**
     * マイページ情報取得
     *
     * @param int $userId
     * @return array
     */
    public function getMypage(int $userId): array
    {
        $userProfile = $this->userRepository->getUserProfileImageByUserId($userId);
        $userProfileImage = $this->getFileUrl($userProfile->userProfileImage->file_name, $userProfile->userProfileImage->file_type);

        $userInfo = $this->userRepository->getStaffFavoritesByUserId($userId);
        $favoriteStaff = $userInfo->staffFavorites->map(function ($staffFavorite) {
            $staff = $staffFavorite->staff;
            $staffProfileImages = $staff->staffProfileImages->map(function ($image) {
                return [
                    'image' => $this->getFileUrl($image->file_name, $image->file_type),
                    'order' => $image->order
                ];
            });

            return [
                'staffId'    => $staff->staff_id,
                'businessId' => $staff->business_id,
                'staffName'  => $staff->staff_name,
                'staffProfileImages' =>  $staffProfileImages->toArray(),
                'businessName' => $staff->businessOperator->business_name,
            ];
        });

        $args = [
            'userId'   => $userProfile->user_id,
            'nickname' => $userProfile->nickname,
            'userProfileImage' => $userProfileImage,
            'favoriteStaff'    => $favoriteStaff,
        ];

        return $args;
    }


    /**
     * 投げ銭ユーザーお気に入り付きスタッフ一覧取得
     *
     * @param int $userId
     * @return array
     */
    public function getFavoriteStaffList(int $userId): array
    {
        $user = $this->userRepository->getStaffFavoritesOrSchedulesByUserId($userId);

        $staffFavorites = $user->staffFavorites->map(function ($staffFavorite) {
            $staff = $staffFavorite->staff;
            $staffProfileImages = $staff->staffProfileImages->map(function ($image) {
                return [
                    'image' => $this->getFileUrl($image->file_name, $image->file_type),
                    'order' => $image->order
                ];
            });

            // staffFavoritesリレーションから直接お気に入りIDを取得
            $favoriteId = $staff->staffFavorites->first()->favorite_id ?? null;

            $todayShiftStatus = $staff->staffSchedules->pluck('shift_status')->first();
            return [
                'staffId' => $staff->staff_id,
                'businessId' => $staff->business_id,
                'favoriteId' => $favoriteId,
                'staffName' => $staff->staff_name,
                'staffProfileImages' =>  $staffProfileImages->toArray(),
                'todayShiftStatus' => (int) $todayShiftStatus,
                'businessName' => $staff->businessOperator->business_name,
            ];
        });

        $args = [
            'staffList' => $staffFavorites->toArray()
        ];

        return $args;
    }

    /**
     * 事業者情報一覧を取得
     *
     * @return array
     */
    public function getBusinessOperatorList(): array
    {
        $businessOperators = $this->businessOperatorRepository->getAllBusinessOperatorsWithImages();


        $businessList = $businessOperators->map(function ($businessOperator) {
            $businessOperatorImages = $businessOperator->businessProfileImages->map(function ($image) {
                return [
                    'image' => $this->getFileUrl($image->file_name, $image->file_type),
                    'order' => $image->order
                ];
            });

            return [
                'businessId'   => $businessOperator->business_id,
                'businessName' => $businessOperator->business_name,
                'businessOperatorImages' => $businessOperatorImages->toArray(),
                'city'         => $businessOperator->city,
            ];
        });

        $args = [
            'businessList' => $businessList->toArray()
        ];

        return $args;
    }

    /**
     * 事業者プロフィール情報取得
     *
     * @param int $businessId
     * @return array $args
     */
    public function getBusinessOperatorShowProfile(int $businessId): array
    {
        // 事業者取得
        $businessOperator = $this->businessOperatorRepository->findBusinessOperatorWithImagesAndCorporation($businessId);
        $businessOperatorImages = $businessOperator->businessProfileImages->map(function ($image) {
            return [
                'image' => $this->getFileUrl($image->file_name, $image->file_type),
                'order' => $image->order
            ];
        });

        $args = [
            'businessName'        => $businessOperator->business_name,
            'corporationName'     => $businessOperator->corporation->corporation_name ?? null,
            'businessDescription' => $businessOperator->business_description,
            'city'                => $businessOperator->city,
            'prefCode'            => $businessOperator->pref_code,
            'businessForm'        => $businessOperator->business_form,
            'images'              => $businessOperatorImages->toArray()
        ];

        return $args;
    }

    /**
     * 事業者に関連するスタッフとそのプロファイル画像を含めたデータを取得
     *
     * @param int $businessId
     * @return array $args;
     */
    public function getBusinessOperatorShowWithStaff(int $businessId): array
    {
        $businessOperator = $this->businessOperatorRepository->findBusinessOperatorWithStaff($businessId);
        $staffData = $businessOperator->staff;

        $staffData = $staffData->map(function ($staff) {
            $staffImages = $staff->staffProfileImages->map(function ($image) {
                return [
                    'image' => $this->getFileUrl($image->file_name, $image->file_type),
                    'order' => $image->order
                ];
            });

            return [
                'staffId'   => $staff->staff_id,
                'staffName' => $staff->staff_name,
                'images'    => $staffImages->toArray()
            ];
        });

        $args = [
            'staff' => $staffData->toArray()
        ];

        return $args;
    }

    /**
     * 事業者に関する口コミと関連ユーザー情報を取得
     *
     * @param int $businessId 事業者のID
     * @return array $reviews
     */
    public function getBusinessReviews(int $businessId): array
    {
        $businessOperator = $this->businessOperatorRepository->getBusinessReviews($businessId);

        $reviews = $businessOperator->businessReviews->sortByDesc(function ($review) {
            return $review->created_at;
        })->values()->map(function ($review) {
            return [
                'reviewId' => $review->review_id,
                'userId' => $review->user_id,
                'nickname' => $review->user->nickname,
                'comment' => $review->comment,
                'createdAgo' => $review->created_at->diffForHumans(),
                'userProfileImage' => $this->getFileUrl($review->user->userProfileImage->file_name, $review->user->userProfileImage->file_type),
            ];
        });

        $args = [
            'businessReviews' => $reviews->toArray()
        ];

        return $args;
    }

    /**
     * 事業者内のスタッフ詳細一覧を加工して取得
     *
     * @param int $businessId 事業者ID
     * @return array $args
     */
    public function getBusinessOperatorShowWithStaffDetail(int $businessId): array
    {
        $businessOperator = $this->businessOperatorRepository->findBusinessOperatorWithStaffDetail($businessId);
        $staffData = $businessOperator->staff;

        $staffData = $staffData->map(function ($staff) {
            $staffProfileImages = $staff->staffProfileImages->map(function ($image) {
                return [
                    'image' => $this->getFileUrl($image->file_name, $image->file_type),
                    'order' => $image->order
                ];
            });

            // staffFavoritesリレーションから直接お気に入りIDを取得
            $favoriteId = $staff->staffFavorites->first()->favorite_id ?? null;

            $todayShiftStatus = $staff->staffSchedules->pluck('shift_status')->first();

            return [
                'staffId' => $staff->staff_id,
                'favoriteId' => $favoriteId,
                'staffName' => $staff->staff_name,
                'todayShiftStatus' => (int) $todayShiftStatus, // 1:出勤、2:休み、3:未定
                'images' => $staffProfileImages,
            ];
        });

        $args = [
            'staffList' => $staffData->toArray(),
            'businessId' => $businessId,
        ];

        return $args;
    }

    /**
     * 事業者口コミ登録
     *
     * @param int $businessId
     * @param int $userId
     * @param string $comment
     * @return BusinessReview
     */
    public function storeReview(int $businessId, int $userId, string $comment): BusinessReview
    {
        return $this->businessOperatorRepository->storeReviw($businessId, $userId, $comment);
    }

    /**
     * 事業者口コミ削除
     *
     * @param int $businessId
     * @param int $reviewId
     * @param int $userId
     * @return bool
     */
    public function deleteReview(int $businessId, int $reviewId, int $userId): bool
    {
        return $this->businessOperatorRepository->deleteReview($businessId, $reviewId, $userId);
    }

    /**
     * お気に入りスタッフ切り替え
     *
     * @param int $userId
     * @param int $staffId
     * @param int|null $favoriteId
     * @return ?int
     */
    public function toggleFavorite(int $userId, int $staffId, ?int $favoriteId): ?int
    {
        return $this->userRepository->toggleFavorite($userId, $staffId, $favoriteId);
    }

    /**
     * いいね切り替え
     *
     * @param int $userId
     * @param int $staffId
     * @param int|null $likeId
     * @return ?int
     */
    public function toggleUserLike(int $userId, int $staffId, ?int $likeId): ?int
    {
        return $this->userRepository->toggleUserLike($userId, $staffId, $likeId);
    }

    /**
     * スタッフの詳細情報を取得
     *
     * @param int $userId ユーザーID
     * @param int $businessId 事業者ID
     * @param int $staffId スタッフID
     * @param int $freePoint 無償ポイントの数
     * @param int $paidPoint 有償ポイントの数
     * @param int $aiCount AIによるカウント数
     * @return array $args
     */
    public function getStaffDetail(int $userId, int $businessId, int $staffId, int $freePoint, int $paidPoint, int $aiCount): array
    {
        $totalPoints = $freePoint + $paidPoint;

        $staff = $this->staffRepository->findByStaffId($staffId);
        $images = $staff->staffProfileImages->map(function ($image) {
            return [
                'image' => $this->getFileUrl($image->file_name, $image->file_type),
                'order' => $image->order
            ];
        });

        $businessOperator = $this->businessOperatorRepository->findByBusinessId($businessId);
        $businessSettings = $this->businessOperatorRepository->getBusinessTippingAmountSettingByBusinessId($businessId)->map(function ($item) {
            return $item->tippingAmountSetting->only(['amount']);
        });
        $favoriteStaff    = $this->userRepository->findUserWithFavoriteStaff($userId, $staffId);
        $userLikeCount    = $this->staffRepository->getUserLikesCountByStaffId($staffId);
        $userLike         = $this->staffRepository->findUserLikeByUserIdAndStaffId($userId, $staffId);

        $args = [
            'aiCount'          => $aiCount,
            'totalPoints'      => $totalPoints,
            'staffId'          => $staffId,
            'staffName'        => $staff->staff_name,
            'comment'          => $staff->comment,
            'images'           => $images,
            'businessId'       => $businessId,
            'businessName'     => $businessOperator->business_name,
            'businessSettings' => $businessSettings,
            'favoriteId'       => $favoriteStaff->favorite_id ?? null,
            'userLikeCount'    => $userLikeCount,
            'userLikeId'       => $userLike->like_id ?? null,
        ];

        return $args;
    }
}
