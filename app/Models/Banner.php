<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Image;


class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'img', 'url', 'blank', 'status'];

    static public $types = ['main' => 'На главной', 'left' => 'Слева', 'content' => 'В тексте'];

    public function typeName() {
        return self::$types[$this->type];
    }

    public static $img_path = 'assets/imgs/ners/';
    public static $img_path_preview = 'assets/imgs/ners/preview/';

    protected static $size_preview_width_main = 889;
    protected static $size_preview_height_main = 460;

    protected static $size_preview_width_left = 252;
    protected static $size_preview_height_left = 371;

    protected static $size_preview_width_content = 560;
    protected static $size_preview_height_content = 479;

    public static function saveImg($request, $type = 'main') {
        if(!$request->hasFile('img') || !$request->file('img')->isValid()) {
            return '';
        }

        $filename = time().'_'.str_random(5).'.'.$request->file('img')->getClientOriginalExtension();
        $request->file('img')->move(public_path(self::$img_path), $filename);
        //preview
        Image::make(public_path(self::$img_path).$filename)
            ->fit(self::getPreviewSizeStatic('width', $type), self::getPreviewSizeStatic('height', $type), function ($constraint) {
                $constraint->upsize();
            })
            ->save(public_path(self::$img_path_preview).$filename);
        return $filename;
    }

    public function getImgPath(){
        return self::$img_path;
    }

    public function getImgPreviewPath(){
        return self::$img_path_preview;
    }

    public function getPreviewSize($attribute = 'width', $type = 'main'){
        $attribute = 'size_preview_'.$attribute.'_'.$type;
        return self::$$attribute;
    }

    static protected function getPreviewSizeStatic($attribute = 'width', $type = 'main'){
        $attribute = 'size_preview_'.$attribute.'_'.$type;
        return self::$$attribute;
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


}
