<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\NgWord;

class NgWordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (NgWord::where('word', $value)->exists()) {
            $fail('ご入力いただいた内容に許可されていない単語が含まれています。別の表現をお試しください。');
        }
    }
}
