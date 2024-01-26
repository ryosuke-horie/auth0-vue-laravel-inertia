<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FileRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }

        $extension = $value->getClientOriginalExtension();
        $fileSize = $value->getSize();

        // 拡張子が png, jpg, jpeg の場合
        if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
            if ($fileSize >= 10 * 1024 * 1024) { // 10MBまで許容
                $fail('画像は、10MB以内です。');
            }
        }

        // 拡張子が mp4 の場合
        if ($extension === 'mp4') {
            if ($fileSize >= 20 * 1024 * 1024) { // 20MBまで許容
                $fail('動画は、20MB以内です。');
            }
        }
    }
}
