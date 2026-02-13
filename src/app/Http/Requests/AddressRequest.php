<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
    protected function prepareForValidation(): void
    {
        if ($this->filled('post_code')) {
            $postal = $this->post_code;

            // 全角 → 半角（数字）
            $postal = mb_convert_kana($postal, 'n');

            // ハイフン類を除去
            $postal = str_replace(['-', '−', 'ー', '―'], '', $postal);

            // 7桁なら 123-4567 に整形
            if (preg_match('/^\d{7}$/', $postal)) {
                $postal = substr($postal, 0, 3) . '-' . substr($postal, 3, 4);
            }

            $this->merge([
                'post_code' => $postal,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'post_code'=>['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address'=>['required', 'string'],
            'building'=>['string','nullable'],
        ];

    }
    public function messages()
    {
        return [
            'post_code.required'=> '郵便番号を入力してください',
            'post_code.string'=> '郵便番号を正しく入力してください',
            'post_code.regex'=> '郵便番号は7桁の数字で入力してください',
            'address.required'=> '住所を入力してください',
            'address.string'=> '住所を正しく入力してください',
            'building.string'=> '建物名を正しく入力してください',
        ];
    }
}
