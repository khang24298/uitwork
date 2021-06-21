<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'display_name' => [
                'required',
                'min:5',
                'max:100',
                Rule::unique('roles', 'display_name')->ignore($this->id),
            ],
            'description' => [
                'required',
                'min:5',
            ],
            'permission' => [
                'required',
            ]
        ];
    }

    public function messages()
    {
        return [
            'display_name.required' => 'Bạn chưa nhập tên vai trò',
            'display_name.min'      => 'Tên vai trò phải có độ dài từ 5 đến 100 ký tự',
            'display_name.max'      => 'Tên vai trò phải có độ dài từ 5 đến 100 ký tự',
            'display_name.unique'   => 'Tên vai trò này đã tồn tại',
            'description.required'  => 'Bạn chưa nhập mô tả cho vai trò',
            'description.min'       => 'Mô tả cho vai trò phải có tối thiểu 5 ký tự',
            'permission.required'   => 'Bạn chưa chọn quyền cho vai trò',
        ];
    }
}
