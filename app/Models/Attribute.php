<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'type', 'unit', 'list', 'is_filter', 'status'];

    static public $types = ['string' => 'Строковый', 'integer' => 'Числовой', 'list' => 'Список'];

    public function typeName() {
        return self::$types[$this->type];
    }

    /**
     * Получение значений списка
     * @return mixed|null
     */
    public function getLists() {
        if($this->type=='list' && $this->list) {
            return json_decode($this->list, true);
        }
        return [];
    }

}
