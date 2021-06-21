<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
                'min:10',
                'max:100',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'phone' => [
                'required',
                'regex:/^0[0-9]{9}$/',
                Rule::unique('users', 'phone')->ignore($this->id),
            ],
            'gender' => [
                'required',
            ],
            'dob' => [
                'required',
            ],
            'password' => [
                'required',
                'min:8',
                'max:20',
            ],
            'department_id' => [
                'required',
            ],
            'role_id' => [
                'required',
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Bạn chưa nhập tên người dùng',
            'name.min'                  => 'Tên người dùng phải có độ dài từ 10 đến 100 ký tự',
            'name.max'                  => 'Tên người dùng phải có độ dài từ 10 đến 100 ký tự',
            'email.required'            => 'Bạn chưa điền email',
            'email.email'               => 'Địa chỉ email không hợp lệ',
            'email.unique'              => 'Địa chỉ email này đã tồn tại',
            'phone.required'            => 'Bạn chưa nhập số điện thoại',
            'phone.regex'               => 'Số điện thoại không hợp lệ (Bao gồm 10 chữ số và bắt đầu bằng 0)',
            'phone.unique'              => 'Số điện thoại này đã tồn tại',
            'gender.required'           => 'Bạn chưa chọn giới tính',
            'dob.required'              => 'Bạn chưa chọn ngày sinh',
            'department_id.required'    => 'Bạn chưa chọn phòng ban',
            'role_id.required'          => 'Bạn chưa chọn vai trò',
            'password.required'         => 'Bạn chưa điền mật khẩu',
            'password.min'              => 'Mật khẩu phải có độ dài từ 8 đến 20 ký tự',
            'password.max'              => 'Mật khẩu phải có độ dài từ 8 đến 20 ký tự',
        ];
    }
}
