<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class Region extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, MultiTranslatableTrait, MenuTrait, SeoTrait;

    public $table = 'regions';
    const CACHE_TTL = 86400; // 1 day

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $translatable = [
        'title',
        'slug',
    ];

    protected static $logFillable = true;

    public function seo()
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Article','article_regions','region_id','article_id');
    }

    public function images()
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('ord');
    }

    public function generalImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('ord', '<', 1)->orderBy('ord');
    }

    public function generalImage(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('ord', '<', 1)
            ->where('cover', 'general')
            ->orderBy('ord');
    }

    public function allImages()
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('ord', '>', 0)->orderBy('ord');
    }

    public function folders()
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }

    public function statusImageShow($status)
    {
        $general = Cache::remember('statusImageShowRegion'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
            return $this->images()->where('cover', $status)->first();
        });
        if(is_object($general))
        {
            return $general->src;
        }else{
            return image_file_path($this->generalImage, '1200x630');
        }
    }

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
