<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'sysname', 'text', 'title', 'description', 'keywords', 'status', 'views'];

    public function goods() {
        return $this->belongsToMany('App\Models\Good', 'good_tag', 'tag_id', 'good_id')->withPivot('sort')->orderBy('sort');
    }

    public function goodsWithoutSort() {
        return $this->belongsToMany('App\Models\Good', 'good_tag', 'tag_id', 'good_id')->withPivot('sort');
    }
}
