<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Image;
use Storage;

class GoodPhoto extends Model
{
    protected $table = 'good_photos';

    protected $fillable = ['good_id', 'img'];

    public static $rules = ['img' => 'image'];

    public static $img_path = 'assets/imgs/goods/';
    public static $img_path_preview = 'assets/imgs/goods/preview/';
    public static $img_path_small = 'assets/imgs/goods/small/';
    public static $img_path_main = 'assets/imgs/goods/main/';

    protected static $size_preview_width = 67;
    protected static $size_preview_height = 67;

    protected static $size_small_width = 450;
    protected static $size_small_height = 450;

    protected static $size_main_width = 183;
    protected static $size_main_height = 183;


    public static function saveImg($file) {
        if (empty($file) || !$file->isValid()) {
            return false;
        }

        $filename = time().'_'.str_random(5).'.'.$file->getClientOriginalExtension();
        $file->move(public_path(self::$img_path), $filename);
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
        if(empty($this) || !$this->img) {
            return false;
        }

        Storage::disk('public')->delete([
            $this->getImgPath().$this->img,
            $this->getImgPreview().$this->img,
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

    public function getImgPreview(){
        return self::$img_path_preview;
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


}
