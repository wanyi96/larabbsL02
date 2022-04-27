<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  //用户权限验证
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            // 'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/unique:users,name' . Auth::id(),
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),//用户名唯一，但将该id排除在外
            'email' => 'required|email',
            'imtroduction' => 'max:80'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名重复，已经被占用',
            'name.regex' => '用户名格式只能为大小写字母，数字，横杠下划线',
            'name,between' => '用户名必须介于3-25个字符之间',
            'name.required' => '用户名不能为空',


        ];
    }
}
