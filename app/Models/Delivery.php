<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Image;
class Delivery extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'descr', 'price', 'img', 'status'];

    public static $img_path = 'assets/imgs/delivery-icon/';
    public static $img_path_preview = 'assets/imgs/delivery-icon/preview/';

    protected static $size_preview_width = 69;
    protected static $size_preview_height = 65;

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
}
