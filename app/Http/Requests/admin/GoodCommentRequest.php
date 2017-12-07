<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\Request;

class GoodCommentRequest extends Request
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
            'good_id' => 'required|exists:goods,id',
            'name' => 'required',
            'date' => 'required|date',
            'email' => 'email',
            'text' => 'required',
        ];
    }
}
