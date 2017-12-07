<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Date;

class GoodComment extends Model
{
    protected $table = 'good_comments';

    protected $fillable = ['good_id', 'date', 'name', 'email', 'text', 'status', 'pros', 'cons'];

    public function good() {
        return $this->belongsTo('App\Models\Good', 'good_id');
    }

    public function dateLocale() {
        return (new Date($this->date))->format('d F Y');
    }

    public function datePicker() {
        return (new Date($this->date))->format('d.m.Y');
    }

}
