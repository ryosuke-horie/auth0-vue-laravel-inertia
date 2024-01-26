<?php

namespace App\Rules;

use Closure;
use App\Repositories\BusinessOperator\BusinessOperatorRepositoryInterface;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class MatchBusinessOperatorPasswordRule implements ValidationRule
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
        $businessOperatorRepository = app()->make(BusinessOperatorRepositoryInterface::class);

        $businessOperator = $businessOperatorRepository->findByBusinessId($this->businessId);

        if (!Hash::check($value, $businessOperator->password)) {
            $fail('事業者パスワードが一致しません。');
        }
    }
}
