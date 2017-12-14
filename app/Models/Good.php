<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Image;

class Good extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id_category', 'name', 'sysname', 'img', 'price', 'article', 'text', 'title', 'description', 'keywords',
                           'status', 'brand_id', 'descr', 'discount', 'stock', 'new', 'act', 'hit', 'video_url'];

    public static $img_path = 'assets/imgs/gds/';
    public static $img_path_preview = 'assets/imgs/gds/preview/';
    public static $img_path_small = 'assets/imgs/gds/small/';
    public static $img_path_main = 'assets/imgs/gds/main/';

    protected static $size_preview_width = 67;
    protected static $size_preview_height = 67;

    protected static $size_small_width = 450;
    protected static $size_small_height = 450;

    protected static $size_main_width = 183;
    protected static $size_main_height = 183;


    public static function saveImg($request) {
        if(!$request->hasFile('img') || !$request->file('img')->isValid()) {
            return '';
        }

        $filename = time().'_'.str_random(5).'.'.$request->file('img')->getClientOriginalExtension();
        $request->file('img')->move(public_path(self::$img_path), $filename);
        //main
        Image::make(public_path(self::$img_path).$filename)
            ->fit(self::$size_main_width, self::$size_main_height, function ($constraint) {
                $constraint->upsize();
            })
            ->save(public_path(self::$img_path_main).$filename);
        //small
        Image::make(public_path(self::$img_path).$filename)
            ->fit(self::$size_small_width, self::$size_small_height, function ($constraint) {
                $constraint->upsize();
            })
            ->save(public_path(self::$img_path_small).$filename);
        //preview
        Image::make(public_path(self::$img_path).$filename)
            ->fit(self::$size_preview_width, self::$size_preview_height, function ($constraint) {
                $constraint->upsize();
            })
            ->save(public_path(self::$img_path_preview).$filename);
        return $filename;
    }

    public function deleteImg() {
        if(!$this->img) {
            return false;
        }

        Storage::disk('public')->delete([
            $this->getImgPath().$this->img,
            $this->getImgPreviewPath().$this->img,
            $this->getImgSmallPath().$this->img,
            $this->getImgMainPath().$this->img,
        ]);
        return true;
    }

    public function getImgPath(){
        return self::$img_path;
    }

    public function getImgSmallPath(){
        return self::$img_path_small;
    }

    public function getImgPreviewPath(){
        return self::$img_path_preview;
    }

    public function getImgMainPath(){
        return self::$img_path_main;
    }

    public function getPreviewSize($attribute = 'width'){
        $attribute = 'size_preview_'.$attribute;
        return self::$$attribute;
    }

    public function getSmallSize($attribute = 'width'){
        $attribute = 'size_small_'.$attribute;
        return self::$$attribute;
    }

    public function getMainSize($attribute = 'width'){
        $attribute = 'size_main_'.$attribute;
        return self::$$attribute;
    }

    public function getSlideClassAttribute() {
        $slideClass = '';

        if($this->hit) $slideClass .= 'mod-hit ';
        if($this->act) $slideClass .= 'mod-sale ';
        if($this->new) $slideClass .= 'mod-new ';

        return $slideClass;
    }

    public function photos() {
        return $this->hasMany('App\Models\GoodPhoto', 'good_id');
    }

    public function comments() {
        return $this->hasMany('App\Models\GoodComment', 'good_id');
    }
    /*
    public function category() {
        return $this->belongsTo('App\Models\Category', 'id_category');
    }
    */

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'good_category', 'good_id', 'category_id')->withPivot('sort');
    }

    public function brand() {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'good_tag', 'good_id', 'tag_id')->withTimestamps();
    }

    public function buyalso()
    {
        return $this->belongsToMany('App\Models\Good', 'good_buyalso', 'good_id', 'good_id2')->withTimestamps();
    }

    public function attributes() {
        return $this->belongsToMany('App\Models\Attribute', 'good_attribute', 'good_id', 'attribute_id')->withPivot('value');
    }

    public function scopePublished($query) {
        return $query->where('status', 1);
    }

    public function scopeHit($query) {
        return $query->where('hit', 1);
    }

    public function scopeAct($query) {
        return $query->where('act', 1);
    }

    public function scopeNew($query) {
        return $query->where('new', 1);
    }

    public function scopeRecentlyAdded($query) {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Проверка Отложен/Нет товар
     * @return bool
     */
    public function isDefer() {
        return session()->has('goods.defer.'.$this->id);
    }

    /**
     * Старая цена
     * @return bool|float
     */
    public function priceOld() {
        if(!$this->price || !$this->discount) {
            return false;
        }
        return ceil($this->price * 100 / (100 - $this->discount));
    }


}
