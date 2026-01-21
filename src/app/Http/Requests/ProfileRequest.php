<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:20'],
            'address'
        ];

    }
    public function messages()
    {
        return [
            'name.required'=>'お名前を入力してください',
            'name.string'=>'お名前を正しく入力してください',
            'name.max'=>'お名前は２０文字以内で入力してください',
        ];
}
}
