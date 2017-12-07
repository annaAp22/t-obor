<?php

namespace App\Http\Requests\admin;

use App\Http\Requests\Request;
use Slug;

class GoodRequest extends Request
{

    public function validate() {
        $this->prepareForValidation();
        parent::validate();
    }


    protected function prepareForValidation() {
        if(empty($this->request->get('sysname'))) {
            $this->request->set('sysname', Slug::make($this->request->get('name'), '_'));
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
        return [
            'categories' => 'required|array|not_empty|exists:categories,id',
            'name' => 'required',
            'descr' => 'max:200',
            'sysname' => 'required|sysname|unique:goods,sysname,'.$this->route('goods'),
            'price' => 'required|numeric',
            'discount' => 'numeric',
            'article' => 'required|unique:goods,article,'.$this->route('goods'),
            'img' => 'image',
            'brand_id' => 'exists:brands,id'
        ];
    }
}
