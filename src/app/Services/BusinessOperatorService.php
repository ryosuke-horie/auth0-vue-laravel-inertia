<?php

namespace App\Services;

use App\Domain\Notification\NotificationList;
use App\Enums\EntityType;
use App\Http\Requests\BusinessOperator\ProfileUpdateRequest;
use App\Models\BusinessOperator;
use App\Models\BusinessProfileImage;
use App\Models\BusinessReview;
use App\Repositories\BusinessOperator\BusinessOperatorRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Inertia\Response;
use App\Enums\ShiftStatus;

class BusinessOperatorService
{
    private BusinessOperatorRepositoryInterface $businessOperatorRepository;

    public function __construct(BusinessOperatorRepositoryInterface $businessOperatorRepository)
    {
        $this->businessOperatorRepository = $businessOperatorRepository;
    }

    /**
     * 事業者情報取得
     *
     * @param int $businessId
     * @return BusinessOperator
     */
    public function findByBusinessId(int $businessId): BusinessOperator
    {
        return $this->businessOperatorRepository->findByBusinessId($businessId);
    }

    /**
     * 事業者プロフィールデータ取得
     *
     * @param int $businessId
     * @return array $args
     */
    public function profile(int $businessId): array
    {
        // 事業者取得
        $businessOperator = BusinessOperator::find($businessId);

        // 親法人が存在する場合、法人名を取得する
        $corporationName = $businessOperator->corporation_name;
        if (!is_null($businessOperator->corporation_id)) {
            $corporationName = $businessOperator->corporation->corporation_name;
        }

        // 事業者画像取得
        $businessProfileImages =  BusinessProfileImage::where('business_id', $businessId)->get();

        $newProfileImages = $businessProfileImages->map(function ($businessProfileImage) {
            return [
                'fileType' => $businessProfileImage['file_type'],
                'fileName' => $businessProfileImage['file_name'],
            ];
        });

        $args = [
            'businessName'        => $businessOperator->business_name,
            'corporationName'     => $corporationName,
            'businessDescription' => $businessOperator->business_description,
            'email'               => $businessOperator->email,
            'images'              => $newProfileImages
        ];

        return $args;
    }

    /**
     * プロフィール更新処理
     * @param int $businessId
     * @param ProfileUpdateRequest $request
     */
    public function updateProfile(int $businessId, ProfileUpdateRequest $request)
    {

        $businessOperator = BusinessOperator::find($businessId);

        $businessOperator->business_description = $request->business_description;
        $businessOperator->save();

        return;
    }
}
