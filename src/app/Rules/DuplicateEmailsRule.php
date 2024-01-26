<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DuplicateEmailsRule implements ValidationRule
{
    protected $validator;

    public function __construct()
    {
        // Laravelのバリデータをインスタンス化
        $this->validator = app('validator');
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $emails = array_column($value, 'email');
        $filterEmails = array_filter($emails, function ($value) {
            return $value !== null;
        });

        if (count($filterEmails) && count($filterEmails) !== count(array_unique($filterEmails))) {
            $fail('メールアドレスが重複しています。');
        }
    }
}
