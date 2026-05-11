<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use App\Traits\CacheableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class Page extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait, MenuTrait, CacheableTrait;

    public $table = 'pages';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'slogan',
        'content',
        'status',
        'src',
        'template',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
        'slug',
        'slogan',
        'content',
    ];

    protected static bool $logFillable = true;

    public function tiers(): HasMany
    {
        return $this->hasMany(PageTier::class);
    }

    public function seo(): MorphMany
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->orderBy('position');
    }

    public function generalImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '<', 1)
            ->orderBy('position');
    }

    public function generalImage(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '<', 1)
            ->where('cover', 'general')
            ->orderBy('position');
    }

    public function coverStatusImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '>', 0)
            ->orderBy('position');
    }

    public function allImages()
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '>', 0)
            ->orderBy('position');
    }

    public function folders()
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }

    public function mainImage()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    public function parent(){
        return $this->hasMany('App\Models\Page','parent_id','id')->orderBy('position','desc')->get();
    }

    public function rowParent(){
        return  $this->belongsTo('App\Models\Page','parent_id');
    }

    public function mainPdfShow()
    {
        $general = Cache::remember('mainPdfShowPage'.$this->id, self::CACHE_TTL, function (){
            return $this->coverStatusImages()->where('type', 'document')->get();
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

    public function mainImageShowLast()
    {
        $general = $this->allImages()->latest()->first();

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

    public function mainImageShow()
    {
        $general = Cache::remember('generalPage'.$this->id, self::CACHE_TTL, function (){
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
//        $general = Cache::remember('statusImageShowPage'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
//            return $this->images()->where('cover', $status)->first();
//        });

        $general = $this->images()->where('cover', $status)->first();

        if(is_object($general))
        {
            return $general->src;
        }else{
//            return image_file_path($this->generalImage, '1200x630');
            return $this->generalImage;
        }
    }

    public function defaultImageShow()
    {
        $general = Cache::remember('defaultImageShowPage'.$this->id, self::CACHE_TTL, function (){
            return $this->coverStatusImages()->where('cover', 'default')->get();
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

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        $locale = app()->getLocale();

        return $query
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;

                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                in_array($request->input('sort_direction'), ['asc', 'desc']) ? $request->input('sort_direction') : 'desc'
            );
    }

    public function scopeFilterTrash(Builder $query, Request $request): Builder
    {
        $locale = app()->getLocale();

        return $query->onlyTrashed()
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;

                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                in_array($request->input('sort_direction'), ['asc', 'desc']) ? $request->input('sort_direction') : 'desc'
            );
    }
}
