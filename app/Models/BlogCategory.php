<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Cache;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait, MenuTrait;

    public $table = 'blog_categories';

    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
        'slug',
        'content'
    ];

    protected static bool $logFillable = true;

    public function seo(): MorphMany
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Blog','blog_cat','blog_category_id','blog_id');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('position');
    }

    public function generalImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('position', '<', 1)->orderBy('position');
    }

    public function allImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('position', '>', 0)->orderBy('position');
    }

    public function folders(): MorphToMany
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }

    public function generalImage(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '<', 1)
            ->where('cover', 'general')
            ->orderBy('position');
    }

    public function statusImageShow($status)
    {
        $general = Cache::remember('statusImageShowArticleCategory'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
            return $this->images()->where('cover', $status)->first();
        });
        if(is_object($general))
        {
            return $general->src;
        }else{
            return image_file_path($this->generalImage, '1200x630');
        }
    }

    // Performance optimization scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeWithBlogs($query, $limit = null)
    {
        $query = $query->withCount(['blogs' => function($q) {
            $q->where('status', true);
        }]);

        if ($limit) {
            $query = $query->with(['blogs' => function($q) use ($limit) {
                $q->where('status', true)
                  ->orderBy('created_at', 'desc')
                  ->limit($limit);
            }]);
        }

        return $query;
    }

    // Get blogs with pagination and caching
    public function getBlogsPaginated($perPage = 12)
    {
        $cacheKey = "category_blogs_{$this->id}_page_" . request()->get('page', 1);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($perPage) {
            return $this->blogs()
                       ->where('status', true)
                       ->orderBy('created_at', 'desc')
                       ->paginate($perPage);
        });
    }

    // Get recent blogs from this category
    public function getRecentBlogs($limit = 5)
    {
        $cacheKey = "category_recent_blogs_{$this->id}_{$limit}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($limit) {
            return $this->blogs()
                       ->where('status', true)
                       ->orderBy('created_at', 'desc')
                       ->limit($limit)
                       ->get();
        });
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
