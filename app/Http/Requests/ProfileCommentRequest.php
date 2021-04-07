<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileCommentRequest extends FormRequest
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
            'comment_profile' => 'required|string|max:50',
        ];
    }
    
    public function messages()
    {
        return [
            'comment_profile.required' => '自己紹介は必須です。',
            'comment_profile.string'   => '自己紹介には文字列を入力してください。',
            'comment_profile.max'      => '自己紹介は50文字以下です。',
        ];
    }
}
