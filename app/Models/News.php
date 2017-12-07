<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Image;
use Storage;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = [
        'name',
        'body',
        'sysname',
        'status',
        'title',
        'keywords',
        'description'
    ];

    public static function boot() {
        parent::boot();

        static::deleted(function($newsRecord) { $newsRecord->deleteImage(); });
    }

    public static $imgPath        = 'assets/imgs/news/';
    public static $imgPathPreview = 'assets/imgs/news/preview/';

    protected static $imgWidthPreview = 265;
    protected static $imgHeightPreview = 180;

    public function scopePublished($query) { $query->where('status', 1); }
    public function scopeRecent($query) { $query->orderBy('created_at', 'desc'); }
    public function scopeBySysname($query, $sysname) { $query->where('sysname', $sysname); }

    public function getShortBodyAttribute() { return mb_substr(strip_tags($this->body), 0, 125).'...'; }
    public function getImagePathAttribute() { return self::$imgPath.$this->img; }
    public function getImagePreviewPathAttribute() { return self::$imgPathPreview.$this->img; }
    public function getImagePreviewWidthAttribute() { return self::$imgWidthPreview; }
    public function getImagePreviewHeightAttribute() { return self::$imgHeightPreview; }

    public static function saveImage($request) {
        if(!$request->hasFile('img') || !$request->file('img')->isValid()) return '';

        $filename = time().'_'.str_random(5).'.'.$request->file('img')->getClientOriginalExtension();
        $request->file('img')->move(public_path(self::$imgPath), $filename);

        Image::make(public_path(self::$imgPath).$filename)
            ->fit(self::$imgWidthPreview, self::$imgHeightPreview, function ($constraint) {
                $constraint->upsize();
            })
            ->save(public_path(self::$imgPathPreview).$filename);
        return $filename;
    }

    public function deleteImage() {
        if(!$this->img) return false;

        Storage::disk('public')->delete([ $this->imagePath, $this->imagePreviewPath ]);
        return true;
    }
}
