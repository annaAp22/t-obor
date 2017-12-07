<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\Request;

class AttributeRequest extends Request
{
    private $rules = [
        'name' => 'required',
        'type' => 'required',

    ];

    public function validate() {
        $this->prepareForValidation();
        parent::validate();
    }


    protected function prepareForValidation() {
        $this->rules['name'] = 'required|unique:attributes,name,'.$this->route('attributes');
        $this->rules['type'] = 'required|in:'.implode(',', array_keys(\App\Models\Attribute::$types));
        if(Request::has('type') && Request::input('type')=='list') {
            $this->rules['values'] = 'array|not_empty';
        }
    }


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
        return $this->rules;
    }
}
