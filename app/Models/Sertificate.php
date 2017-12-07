<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Image;

class Sertificate extends Model
{
    protected $fillable = ['img'];

    public static $img_path = 'assets/imgs/sertificates/';
    public static $img_path_preview = 'assets/imgs/sertificates/preview/';

    protected static $size_preview_width = 192;
    protected static $size_preview_height = 280;

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