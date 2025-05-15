<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class Data extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait;

    public $table = 'datas';
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
        'links',
        'status',
        'files',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $translatable = [
        'title',
        'slug',
        'content',
        'links',
    ];

    protected static $logFillable = true;

    public function seo(): \Illuminate\Database\Eloquent\Relations\MorphMany
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

    public function statusImageShow($status)
    {
        $general = Cache::remember('statusImageShowData'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
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
