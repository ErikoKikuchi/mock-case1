<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'payment_method' => ['required', 'string','in:card,convenience',],
            'shipping_address_id' => ['nullable', 'exists:shipping_addresses,id'],
        ];
    }
    public function messages()
    {
        return [
        'payment_method_id.required'=>'支払方法を入力してください'
        ];
    }
}
