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

            'comment' => 'required|string|max:50',

            'comment_profile' => 'required|string|max:50',

            'file' => 
                'required',
                'file',
                'image',
                'mimes:jpeg,png',
        ];
    }
    
    public function messages()
    {
        return [
            'text.required' => 'タイトルは必須です。',
            'location.required' => 'マーカー情報は必須です。',
            'text.string'   => 'タイトルには文字列を入力してください。',
            'text.max'      => 'タイトルは30文字以下です。',
            
            'comment.required' => 'コメントは必須です。',
            'comment.string'   => 'コメントには文字列を入力してください。',
            'comment.max'      => 'コメントは50文字以下です。',

            'comment_profile.required' => '自己紹介は必須です。',
            'comment_profile.string'   => '自己紹介には文字列を入力してください。',
            'comment_profile.max'      => '自己紹介は50文字以下です。',

            'file.required' => '写真は必須です。',
        ];
    }
}
