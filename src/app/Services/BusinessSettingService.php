<?php

namespace App\Services;

use App\Domain\Notification\NotificationList;
use App\Enums\EntityType;
use App\Http\Requests\BusinessOperator\ProfileUpdateRequest;
use App\Models\BusinessOperator;
use App\Models\BusinessProfileImage;
use App\Models\BusinessReview;
use App\Repositories\BusinessOperator\BusinessOperatorRepositoryInterface;
use App\Repositories\Admin\AdminRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Inertia\Response;
use App\Enums\ShiftStatus;

class BusinessSettingService
{
    private BusinessOperatorRepositoryInterface $businessOperatorRepositoryInterface;
    private AdminRepositoryInterface $adminRepositoryInterface;

    public function __construct(
        BusinessOperatorRepositoryInterface $businessOperatorRepositoryInterface,
        AdminRepositoryInterface $adminRepositoryInterface
    ) {
        $this->businessOperatorRepositoryInterface = $businessOperatorRepositoryInterface;
        $this->adminRepositoryInterface = $adminRepositoryInterface;
    }

    /**
     * 公開設定画面用データ取得
     * @param int $businessId
     */
    public function publish(int $businessId)
    {
        $setting = $this->businessOperatorRepositoryInterface->getBusinessSettingByBusinessId($businessId);

        return $setting;
    }

    /**
     * 公開設定更新
     */
    public function updatePublish(int $settingId, bool $isPublish)
    {

        $param = [
            'is_publish'    => $isPublish
        ];

        $this->businessOperatorRepositoryInterface->updateBusinessSettingBySettingId($settingId, $param);
    }

    /**
     * 口コミ公開設定更新
     */
    public function updateReviewPublish(int $settingId, bool $isReviewPublish)
    {
        $param = [
            'is_review_publish'    => $isReviewPublish
        ];

        $this->businessOperatorRepositoryInterface->updateBusinessSettingBySettingId($settingId, $param);
    }

    /**
     * スタッフランキング公開設定更新
     */
    public function updateStaffRankingPublish(int $settingId, bool $isStaffRankingPublish)
    {
        $param = [
            'is_staff_ranking_publish'    => $isStaffRankingPublish
        ];

        $this->businessOperatorRepositoryInterface->updateBusinessSettingBySettingId($settingId, $param);
    }

    /**
     * 投げ銭金額設定情報の取得
     */
    public function settingTip(int $businessId)
    {
        // 投げ銭金額リストの取得
        $amounts = $this->adminRepositoryInterface->getAllTippingAmountSetting();

        $args = $amounts->map(function ($item) use ($businessId) {
            $businessTippingAmountSettings = $this->businessOperatorRepositoryInterface->getBusinessTippingAmountSettingByBusinessSetting($businessId, $item->setting_id);
            $isSelect = false;
            if (!$businessTippingAmountSettings->isEmpty()) {
                $isSelect = true;
            }
            return [
                'settingId' => $item->setting_id,
                'amount'    => $item->amount,
                'isSelect'  => $isSelect
            ];
        });

        return $args;
    }

    /**
     * 投げ銭金額設定更新
     */
    public function updateTip(int $businessId, array $settingIdList)
    {
        // 削除処理
        $this->businessOperatorRepositoryInterface->deleteBusinessTippingAmountSettingByBusiness($businessId);

        // 登録処理
        foreach ($settingIdList as $settingId) {
            $this->businessOperatorRepositoryInterface->createBusinessTippingAmountSetting($businessId, $settingId);
        }
    }
}
