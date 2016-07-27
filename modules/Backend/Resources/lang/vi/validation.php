<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => ':attribute không hợp lệ.',
    'exists'               => ':attribute đã tồn tại.',
    'filled'               => 'The :attribute field is required.',
    'image'                => ':attribute phải là file ảnh.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => ':attribute phải là số.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => ':attribute phải nhỏ hơn :max.',
        'file'    => ':attribute may not be greater than :max kilobytes.',
        'string'  => ':attribute phải nhiều nhất :max ký tự.',
        'array'   => ':attribute may not have more than :max items.',
        'integer' => ':attribute phải nhỏ hơn :max.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute phải lớn hơn :min.',
        'file'    => ':attribute must be at least :min kilobytes.',
        'string'  => ':attribute phải ít nhất :min ký tự.',
        'array'   => ':attribute must have at least :min items.',
        'integer' => ':attribute phải lớn hơn :min.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => ':attribute không thể rỗng.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => ':attribute và :other phải trùng khớp.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',
    'does_not_exist' => 'Trang web yêu cầu không tồn tại.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
//        'email' => [
//            'required' => 'Well you need to tell us your email address :)',
//        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'Tên',
        'email' => 'Thư điện tử',
        'title' => 'Tiêu đề',
        'status' => 'Tình trạng',
        'password' => 'Mật khẩu',
        'retype_password' => 'Xác nhận mật khẩu',
        'new_password' => 'Mật khẩu mới',
        'weight' => 'Thứ tự',
        'role_id' => 'Vai trò',
        'view_count' => 'Lượt xem',
        'priority' => 'Độ ưu tiên',
        'category' => 'Chủ đề',
        'parent' => 'Cha',

        'admin' => 'Tài khoản',
        'role' => 'Vai trò',
        'term' => 'Chủ đề',
        'post' => 'Bài viết',
        'menu_link' => 'Liên kết',
        'alias' => 'Biệt danh',
        'slug' => 'Biệt danh',
        'url' => 'Địa chỉ liên kết',
        'thumb_url' => 'Hình đại diện'
    ],

];
