<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
                Rule::unique('permissions', 'display_name')->ignore($this->id),
            ],
            'group_permission_id' => [
                'required',
            ],
            'description' => [
                'required',
                'min:5',
            ],
        ];
    }

    public function messages()
    {
        return [
            'display_name.required'         => 'Bạn chưa nhập tên quyền',
            'display_name.min'              => 'Tên quyền phải có độ dài từ 5 đến 100 ký tự',
            'display_name.max'              => 'Tên quyền phải có độ dài từ 5 đến 100 ký tự',
            'display_name.unique'           => 'Tên quyền này đã tồn tại',
            'group_permission_id.required'  => 'Bạn chưa chọn nhóm quyền',
            'description.required'          => 'Bạn chưa nhập mô tả cho quyền',
            'description.min'               => 'Mô tả cho quyền phải có tối thiểu 5 ký tự',
        ];
    }
}
