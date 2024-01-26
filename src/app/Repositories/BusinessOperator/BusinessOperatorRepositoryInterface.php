<?php

namespace App\Repositories\BusinessOperator;

use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessOperator;
use App\Models\BusinessReview;
use App\Models\BusinessSetting;
use App\Models\BusinessTippingAmountSetting;
use Illuminate\Support\Collection;

interface BusinessOperatorRepositoryInterface
{
    /**
     * 事業者情報取得
     *
     * @param int $businessId
     * @return BusinessOperator
     */
    public function findByBusinessId(int $businessId): BusinessOperator;

    /**
     * 事業者とそのプロファイル画像を含む情報の一覧を取得
     *
     * @return Collection|BusinessOperator[]
     */
    public function getAllBusinessOperatorsWithImages(): Collection;

    /**
     * 事業者情報とそのプロファイル画像、および関連する法人情報を取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function findBusinessOperatorWithImagesAndCorporation(int $businessId): ?BusinessOperator;

    /**
     * スタッフ情報一覧を取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function findBusinessOperatorWithStaff(int $businessId): ?BusinessOperator;

    /**
     * 事業者内のスタッフ詳細一覧を取得
     *
     * 事業者情報、スタッフ情報、お気に入りスタッフ、スケジュール
     * 事業者内ランキング用にポイント降順、名前昇順で取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function findBusinessOperatorWithStaffDetail(int $businessId): ?BusinessOperator;

    /**
     * 事業者口コミを取得
     *
     * @param int $businessId
     * @return BusinessOperator|null
     */
    public function getBusinessReviews(int $businessId): ?BusinessOperator;

    /**
     * 口コミ登録
     *
     * @param int $businessId
     * @param int $userId
     * @param string $comment
     * @return BusinessReview
     */
    public function storeReviw(int $businessId, int $userId, string $comment): BusinessReview;

    /**
     * 口コミ削除
     *
     * @param int $businessId
     * @param int $reviewId
     * @param int $userId
     * @return bool
     */
    public function deleteReview(int $businessId, int $reviewId, int $userId): bool;

    /**
     * 設定情報を取得
     * @param int $businessId
     * @return BusinessSetting
     */
    public function getBusinessSettingByBusinessId(int $businessId): BusinessSetting;

    /**
     * 設定情報更新
     * @param int $settingId
     * @param array $param
     */
    public function updateBusinessSettingBySettingId(int $settingId, array $param): void;

    /**
     * 投げ銭金額設定を取得
     * @param int $businessId
     * @param int $settingId
     * @return Collection
     */
    public function getBusinessTippingAmountSettingByBusinessSetting(int $businessId, int $settingId): Collection;

    /**
     * 投げ銭金額設定を削除
     * @param int $businessId
     */
    public function deleteBusinessTippingAmountSettingByBusiness(int $businessId): void;

    /**
     * 投げ銭金額設定を登録
     * @param int $businessId
     */
    public function createBusinessTippingAmountSetting(int $businessId, int $settingId): void;

    /**
     * 投げ銭設定情報を一括取得
     * @param int $businessId
     * @return Collection
     */
    public function getBusinessTippingAmountSettingByBusinessId(int $businessId): Collection;
}
