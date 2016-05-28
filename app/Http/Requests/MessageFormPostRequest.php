<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MessageFormPostRequest extends Request
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
            'm_id' => 'required|integer',
            'm_title' => 'required|string|max:64' ,
            'm_content' => 'required|string|max:20480',
            'm_create_date' => 'required|date_format:Y-m-d H:i:s',
            'msg_id' => 'required|integer',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            
        ];
    }
}
