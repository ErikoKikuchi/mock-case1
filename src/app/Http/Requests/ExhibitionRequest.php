<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'title' =>['required','string'],
            'image' =>['required', 'file', 'image', 'mimes:jpeg,jpg,png','max:10240'],
            'brand' =>['nullable','string'],
            'description'=>['required','string','max:255'],
            'price'=>['required','numeric','min:0'],
            'condition'=>['required','in:1,2,3,4'],
            'categories' => ['required', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }
    public function messages(){
        return [
            'title.required'=>'商品名を入力してください',
            'title.string'=>'商品名を正しく入力してください',
            'image.required' => '画像を登録してください',
            'image.file' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.image' =>'「.png」または「.jpeg」形式でアップロードしてください',
            'image.mimes' =>'「.png」または「.jpeg」形式でアップロードしてください',
            'image.max'=>'画像は最大１０Ｍまでのものを使用してください',
            'brand.string'=>'ブランド名を正しく入力してください',
            'description.required'=>'商品説明を入力してください',
            'description.string'=>'商品説明を正しく入力してください',
            'description.max'=>'商品説明は最大255文字以内で入力してください',
            'price.required'=>'商品の値段を入力してください',
            'price.numeric'=>'商品の値段は数字で入力してください',
            'price.min'=>'商品の値段は0円以上で入力してください',
            'condition.required'=>'商品の状態を選択してください',
            'condition.in'=>'商品の状態を正しく選択してください',
            'categories.required'=>'カテゴリーを選択してください',
            'categories.array'=>'カテゴリーを正しく選択してください',
            'categories.integer'=>'カテゴリーを正しく選択してください',
            'categories.exists'=>'カテゴリーを正しく選択してください',
        ];
    }
}
