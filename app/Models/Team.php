<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class Team extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait;

    public $table = 'teams';
    const CACHE_TTL = 86400; // 1 day

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'work',
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $translatable = [
        'title',
        'work',
        'slug',
        'content',
    ];

    protected static $logFillable = true;

    public function modelCategory()
    {
        return $this->belongsToMany('App\Models\TeamCategory','team_cats','team_id','team_category_id');
    }

    public function seo()
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function images()
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('ord');
    }

    public function generalImages()
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

    public function mainImage()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    public function mainImageShow()
    {
        $general = Cache::remember('generalTeam'.$this->id, self::CACHE_TTL, function (){
            return $this->generalImages()->first();
        });

        if(is_object($general))
        {
            return $general;
        }else{
            $file_first = Cache::remember('file_first', self::CACHE_TTL, function (){
                return File::first();
            });
            return $file_first;
        }
    }

    public function statusImageShow($status)
    {
        $general = Cache::remember('statusImageShowTeam'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
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
