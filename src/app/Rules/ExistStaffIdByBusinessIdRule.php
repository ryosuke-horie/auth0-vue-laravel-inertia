<?php

namespace App\Rules;

use App\Repositories\Staff\StaffRepositoryInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistStaffIdByBusinessIdRule implements ValidationRule
{
    private int $businessId;

    public function __construct(int $businessId)
    {
        $this->businessId = $businessId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $staffRepository = app()->make(StaffRepositoryInterface::class);

        $staffIdsforDB = $staffRepository->getStaffByBusinessId($this->businessId)->pluck('staff_id');

        $isNotEmpty = collect($value)->diff($staffIdsforDB)->isNotEmpty();

        if ($isNotEmpty) {
            $fail('事業者に登録されていないスタッフが選択されています。ご確認の上、再度やり直してください。');
        }
    }
}
