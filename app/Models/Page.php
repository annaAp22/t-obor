<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['name', 'sysname', 'content'];

    public function vars() {
        return $this->hasMany('App\Models\PageVar', 'page_id');
    }

    public function getVar($var) {
        $page_var = $this->hasMany('App\Models\PageVar', 'page_id')->where('var', $var)->first();
        return ($page_var ? $page_var->value : null);
    }

    public function photos() {
        return $this->hasMany('App\Models\PagePhoto', 'page_id');
    }

}
