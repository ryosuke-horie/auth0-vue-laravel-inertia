<?php

namespace App\Repositories\BusinessOperator;

use App\Models\BusinessOperator;
use App\Models\BusinessApplication;
use App\Models\BusinessProfileImage;
use App\Models\BusinessReview;
use App\Models\BusinessSetting;
use App\Models\BusinessTippingAmountSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BusinessOperatorRepository implements BusinessOperatorRepositoryInterface
{
    /**
     * 事業者情報取得
     *
     * @param int $businessId
     * @return BusinessOperator
     */
    public function findByBusinessId(int $businessId): BusinessOperator
    {
        return BusinessOperator::find($businessId);
    }

    /**
     * 事業者とそのプロファイル画像を含む情報の一覧を取得
     *
     * @return Collection|BusinessOperator[]
     */
    public function getAllBusinessOperatorsWithImages(): Collection
    {
        return BusinessOperator::with('businessProfileImages')->get();
    }

    /**
     * 事業者情報、そのプロファイル画像、および関連する法人情報を取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function findBusinessOperatorWithImagesAndCorporation(int $businessId): ?BusinessOperator
    {
        return BusinessOperator::with(['businessProfileImages', 'corporation'])->find($businessId);
    }

    /**
     * スタッフ情報一覧を取得
     * 事業者内ランキング用にポイント降順、名前昇順で取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function findBusinessOperatorWithStaff(int $businessId): ?BusinessOperator
    {
        return BusinessOperator::with(['staff' => function ($query) {
            $query->orderBy('points', 'desc')
                    ->orderBy('staff_name', 'asc');
        }, 'staff.staffProfileImages'])->find($businessId);
    }

    /**
     * 事業者内のスタッフ詳細一覧を取得
     *
     * 事業者情報、スタッフ情報、お気に入りスタッフ、スケジュール
     * 事業者内ランキング用にポイント降順、名前昇順で取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function findBusinessOperatorWithStaffDetail(int $businessId): ?BusinessOperator
    {
        return BusinessOperator::with(['staff' => function ($query) {
            $query->orderBy('points', 'desc')
                    ->orderBy('staff_name', 'asc');
        }, 'staff.staffProfileImages', 'staff.staffFavorites', 'staff.staffSchedules'])->find($businessId);
    }

    /**
     * 事業者口コミを取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function getBusinessReviews(int $businessId): ?BusinessOperator
    {
        return BusinessOperator::with('businessReviews.user.userProfileImage')->find($businessId);
    }

    /**
     * 口コミ登録
     *
     * @param int $businessId
     * @param int $userId
     * @param string $comment
     * @return BusinessReview
     */
    public function storeReviw(int $businessId, int $userId, string $comment): BusinessReview
    {
        return BusinessReview::create([
            'business_id' => $businessId,
            'user_id' => $userId,
            'comment' => $comment
        ]);
    }

    /**
     * 口コミ削除
     *
     * @param int $businessId
     * @param int $reviewId
     * @return bool
     */
    public function deleteReview(int $businessId, int $reviewId, int $userId): bool
    {
        // 特定のビジネスIDとレビューIDに対応するレビューを検索
        return BusinessReview::where('business_id', $businessId)
                                ->where('review_id', $reviewId)
                                ->where('user_id', $userId)
                                ->firstOrFail()->delete();
    }

    public function getBusinessTippingAmountSettingByBusinessId(int $businessId): Collection
    {
        return BusinessTippingAmountSetting::with('tippingAmountSetting')->where('business_id', $businessId)->get();
    }

    public function getBusinessSettingByBusinessId(int $businessId): BusinessSetting
    {
        return BusinessSetting::where('business_id', $businessId)
            ->first();
    }

    public function updateBusinessSettingBySettingId(int $settingId, array $param): void
    {
        $businessSetting = BusinessSetting::find($settingId);
        $businessSetting->fill($param);
        $businessSetting->save();
    }

    public function getBusinessTippingAmountSettingByBusinessSetting(int $businessId, int $settingId): Collection
    {
        return BusinessTippingAmountSetting::where('business_id', $businessId)
            ->where('setting_id', $settingId)
            ->get();
    }

    public function deleteBusinessTippingAmountSettingByBusiness(int $businessId): void
    {
        BusinessTippingAmountSetting::where('business_id', $businessId)
        ->delete();
    }

    public function createBusinessTippingAmountSetting(int $businessId, int $settingId): void
    {
        BusinessTippingAmountSetting::create([
            'business_id'   => $businessId,
            'setting_id'    => $settingId
        ]);
    }
}
