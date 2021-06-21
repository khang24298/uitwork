<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupPermissionRequest extends FormRequest
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
            'name' => [
                'required',
                'min:5',
                'max:100',
                Rule::unique('group_permissions', 'name')->ignore($this->id),
            ],
            'description' => [
                'required',
                'min:5',
            ],
        ];
    }

    //
    public function messages()
    {
        return [
            'name.required'         => 'Bạn chưa nhập tên nhóm quyền',
            'name.min'              => 'Tên nhóm quyền phải có độ dài từ 5 đến 100 ký tự',
            'name.max'              => 'Tên nhóm quyền phải có độ dài từ 5 đến 100 ký tự',
            'name.unique'           => 'Nhóm quyền này đã tồn tại',
            'description.required'  => 'Bạn chưa nhập mô tả cho nhóm quyền',
            'description.min'       => 'Mô tả cho nhóm quyền phải có tối thiểu 5 ký tự',
        ];
    }
}
