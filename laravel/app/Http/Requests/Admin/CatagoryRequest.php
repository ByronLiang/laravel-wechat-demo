<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CatagoryRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'img_url' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '分类名称',
            'img_url' => '封面图片',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入分类名称',
            'img_url.required' => '请上传封面图片',
        ];
    }
}
