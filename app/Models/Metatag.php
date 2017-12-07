<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metatag extends Model
{
    protected $fillable = ['name', 'url', 'route', 'title', 'description', 'keywords'];
}
