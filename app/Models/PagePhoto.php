<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Image;
use Storage;

class PagePhoto extends Model
{
    protected $table = 'page_photos';

    protected $fillable = ['page_id', 'name', 'img'];

    public static $rules = ['img' => 'image'];

    public static $img_path = 'assets/services/pages/';

    public static $img_path_preview = 'assets/services/pages/preview/';

    protected static $size_preview_width = 253;
    protected static $size_preview_height = 175;

    public static function saveImg($file) {
        if (empty($file) || !$file->isValid()) {
            return false;
        }

        $filename = time().'_'.str_random(5).'.'.$file->getClientOriginalExtension();
        $file->move(public_path(self::$img_path), $filename);
        //create preview
        Image::make(public_path(self::$img_path).$filename)
            //->resize(self::$size_preview_width, self::$size_preview_height)
            ->fit(self::$size_preview_width, self::$size_preview_height, function ($constraint) {
                $constraint->upsize();
            })
            ->save(public_path(self::$img_path_preview.$filename));

        return $filename;
    }

    public function deleteImg() {
        if(empty($this) || !$this->img) {
            return false;
        }

        Storage::disk('public')->delete([
            $this->getImgPath().$this->img,
            $this->getImgPreview().$this->img,
        ]);
        return true;
    }

    public function getImgPath(){
        return self::$img_path;
    }

    public function getImgPreview(){
        return self::$img_path_preview;
    }
}
