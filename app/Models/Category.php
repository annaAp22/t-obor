<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Image;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['id_parent', 'name', 'sysname', 'icon', 'img', 'img_main', 'text', 'title', 'description', 'keywords', 'status', 'sort', 'new', 'act', 'hit'];

    public static $icon_path = 'assets/imgs/categors/icons/';

    public static $img_path = 'assets/imgs/categors/';
    public static $img_path_preview = 'assets/imgs/categors/preview/';

    protected static $size_preview_width = 145;
    protected static $size_preview_height = 180;

    public static $img_main_path = 'assets/imgs/categors/main/';

    protected static $size_img_main_width = 559;
    protected static $size_img_main_height = 376;

    public static function saveImgMain($request) {
        if(!$request->hasFile('img_main') || !$request->file('img_main')->isValid()) {
            return '';
        }

        $filename = time().'_'.str_random(5).'.'.$request->file('img_main')->getClientOriginalExtension();
        $request->file('img_main')->move(public_path(self::$img_main_path), $filename);

        Image::make(public_path(self::$img_main_path).$filename)
            ->fit(self::$size_img_main_width, self::$size_img_main_height, function ($constraint) {
                $constraint->upsize();
            })
            ->save();
        return $filename;
    }

    public function deleteImgMain() {
        if(!$this->img_main) {
            return false;
        }

        Storage::disk('public')->delete([
            $this->getImgMainPath().$this->img_main,
        ]);
        return true;
    }

    public function getImgMainPath(){
        return self::$img_main_path;
    }


    public static function saveIcon($request) {
        if(!$request->hasFile('icon') || !$request->file('icon')->isValid()) {
            return '';
        }

        $filename = time().'_'.str_random(5).'.'.$request->file('icon')->getClientOriginalExtension();
        $request->file('icon')->move(public_path(self::$icon_path), $filename);
        return $filename;
    }

    public function deleteIcon() {
        if(!$this->icon) {
            return false;
        }

        Storage::disk('public')->delete([
            $this->getIconPath().$this->icon,
        ]);
        return true;
    }

    public function getIconPath(){
        return self::$icon_path;
    }

    public static function saveImg($request) {
        if(!$request->hasFile('img') || !$request->file('img')->isValid()) {
            return '';
        }

        $filename = time().'_'.str_random(5).'.'.$request->file('img')->getClientOriginalExtension();
        $request->file('img')->move(public_path(self::$img_path), $filename);

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
        ]);
        return true;
    }

    public function getImgPath(){
    return self::$img_path;
}

    public function getImgPreviewPath(){
        return self::$img_path_preview;
    }

    public function getPreviewSize($attribute = 'width'){
        $attribute = 'size_preview_'.$attribute;
        return self::$$attribute;
    }

    public function categories() {
        return $this->hasMany('App\Models\Category', 'id_parent');
    }

    public function parent() {
        return $this->belongsTo('App\Models\Category', 'id_parent');
    }

    public function goods() {
        return $this->belongsToMany('App\Models\Good', 'good_category', 'category_id', 'good_id')->withPivot('sort')->orderBy('good_category.sort');
    }

    public function goodsWithoutSort() {
        return $this->belongsToMany('App\Models\Good', 'good_category', 'category_id', 'good_id')->withPivot('sort');
    }

    public function getFiltersAttribute() {
        $filters = [];

        foreach($this->goods as $product) {
            foreach($product->relations['attributes'] as $attr) {
                if(isset($filters[$attr->id])) continue;

                $filters[$attr->id] = $attr;
            }
        }

        return collect($filters);
    }

    public function getHasChildrenAttribute() {
        return $this->categories->count() > 0;
    }

    public function getGoodsCountAttribute() {
        if(!$this->hasChildren) return $this->goods->count();

        $count = 0;
        foreach($this->categories as $cat)
            $count += $cat->goodsCount;

        return $count;
    }

    public function getMinPriceAttribute() {

        if(!$this->hasChildren)
            return $this->goods->min('price');

        $min = PHP_INT_MAX;
        foreach($this->categories as $cat) {
            $catMinPrice = $cat->goods->min('price');
            if($catMinPrice < $min) $min = $catMinPrice;
        }

        return ($min == 999999) ? false : $min;
    }
}
