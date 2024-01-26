<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidUserTipAmountRule;

class UserTipStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => 'string|max:200|nullable',
            'amount'  => ['required', 'integer', 'min:300', new ValidUserTipAmountRule()],
        ];
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'amount.required' => 'ギフトは必ず選択してください。',
            'amount.integer'  => 'ギフトは整数である必要があります。',
            'amount.min'      => 'ギフトは必ず選択してください。',
        ];
    }
}
