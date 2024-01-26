<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class ValidUserTipAmountRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $freePoint = Auth::guard('user')->user()->free_points;
        $paidPoint = Auth::guard('user')->user()->paid_points;
        $totalPoint = $freePoint + $paidPoint;

        if ($value > $totalPoint) {
            $fail('ポイントが不足しています。ポイントの購入をお願いいたします。');
        }
    }
}
