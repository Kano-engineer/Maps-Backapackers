<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'keyword' => 'required',
            'keyword2' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'keyword.required' => 'キーワードは必須です。',
            'keyword2.required' => '都道府県名は必須です。',
        ];
    }
}
