<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CustomPasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 入力文字列が8文字以上、大文字小文字数字が含まれているかを確認
        if (
            (strlen($value) < 8) ||
            (strlen($value) > 100) ||
            (!preg_match('/[A-Z]/', $value)) ||
            (!preg_match('/[a-z]/', $value)) ||
            (!preg_match('/\d/', $value))
        ) {
            $fail('パスワードは8文字以上から100文字以内で、英大文字・英小文字・数字それぞれを最低1文字ずつ含んでください。');
        }
    }
}
