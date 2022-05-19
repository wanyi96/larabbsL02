<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2'
        ];
    }

    public function messages()
    {
        return [
            // Validation messages
            'content.required' => '内容不能为空',
            'content.min' => '内容最少两个字符',
        ];
    }
}
