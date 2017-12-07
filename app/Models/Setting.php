<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['type', 'var', 'value'];

    protected $table = 'settings';

    public static function getVar($var) {
        $setting = self::where('var', $var)->first();
        if(!empty($setting)) {
            return $setting->type=='array' ? json_decode($setting->value, true) : $setting->value;
        }
    }

    public function valueUnpuck() {
        if($this->type=='array') {
            $this->value = json_decode($this->value, true);
        }
        return $this;
    }


    public function getVarArray() {
        if($this->type=='array') {
            $this->values = json_decode($this->value, true);
            $this->value = '';
        }
    }

}
