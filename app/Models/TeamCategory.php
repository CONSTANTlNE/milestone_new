<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class TeamCategory extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public $table = 'team_categories';
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
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $translatable = [
        'title',
        'slug',
        'content',
    ];

    protected static $logFillable = true;

    public function blog()
    {
        return $this->belongsToMany('App\Models\Team','team_cats','team_category_id','team_id');
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

    public function coverStatusImages()
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('ord');
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
        $general = Cache::remember('generalTeamCategory'.$this->id, self::CACHE_TTL, function (){
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
        $general = Cache::remember('statusImageShowTeamCategory'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
            return $this->coverStatusImages()->where('cover', $status)->first();
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
}

