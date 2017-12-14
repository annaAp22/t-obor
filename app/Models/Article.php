<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Image;
use Date;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'sysname', 'img', 'date', 'descr', 'text', 'title', 'description', 'keywords', 'status'];

    public static $img_path = 'assets/imgs/articls/';
    public static $img_path_preview = 'assets/imgs/articls/preview/';

    protected static $size_preview_width = 360;
    protected static $size_preview_height = 239;

    public static function saveImg($request) {
        if(!$request->hasFile('img') || !$request->file('img')->isValid()) {
            return '';
        }

        $filename = time().'_'.str_random(5).'.'.$request->file('img')->getClientOriginalExtension();
        $request->file('img')->move(public_path(self::$img_path), $filename);
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

    public function getShortBodyAttribute() { return mb_substr($this->descr, 0, 125).'...'; }

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'article_category', 'article_id', 'category_id')->withTimestamps();;
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'article_tag', 'article_id', 'tag_id')->withTimestamps();;
    }

    public function dateLocale() {
        return (new Date($this->date))->format('d F Y');
    }

    public function datePicker() {
        return (new Date($this->date))->format('d.m.Y');
    }

    public function dateFormat() {
        return (new Date($this->date))->format('F').'<div class="day-year">'.(new Date($this->date))->format('d | Y').'</div>';
    }

}
