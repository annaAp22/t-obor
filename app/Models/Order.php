<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Date;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    static public $statuses = ['wait' => 'В ожидании', 'work' => 'В работе', 'send' => 'Отправлен', 'cancel' => 'Отменен', 'complete' => 'Завершен' ];

    protected $fillable = ['datetime', 'name', 'email', 'phone', 'descr', 'address', 'delivery_id', 'payment_id', 'payment_add', 'amount', 'status'];

    public function statusName() {
        return self::$statuses[$this->status];
    }

    public function dateLocale() {
        return (new Date($this->datetime))->format('d F Y H:i');
    }

    public function datePicker() {
        return (new Date($this->datetime))->format('d.m.Y H:i');
    }

    public function goods() {
        return $this->belongsToMany('App\Models\Good', 'order_good', 'order_id', 'good_id')->withPivot('cnt', 'price')->withTimestamps();;
    }

}
