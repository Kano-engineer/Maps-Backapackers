<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'required|string|max:30',
            'location' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'text.required' => 'タイトルは必須です。',
            'location.required' => 'マーカー情報は必須です。',
            'text.string'   => 'タイトルには文字列を入力してください。',
            'text.max'      => 'タイトルは30文字以下です。',
        ];
    }
}
