<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use App\Traits\TagTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
class Blog extends Model
{
    use HasFactory, Searchable, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, TagTrait, MultiTranslatableTrait;

    public $table = 'blogs';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'title',
        'slug',
        'slogan',
        'content',
        'status',
        'views',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
        'slug',
        'slogan',
        'content'
    ];

    protected static bool $logFillable = true;

    public function seo(): MorphMany
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function reporter(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\BlogCategory','blog_cat','blog_id','blog_category_id');
    }

//    public function tags(): BelongsToMany
//    {
//        return $this->belongsToMany('App\Models\Tag','blog_tags','article_id','tag_id');
//    }

//    public function tagViews($langs): BelongsToMany
//    {
//        return $this->belongsToMany(Tag::class, 'article_tags', 'article_id', 'tag_id')
//            ->whereIn('tags.lang', [$langs]);
//    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('position');
    }

    public function generalImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('position', '<', 1)->orderBy('position');
    }

    public function generalImage(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '<', 1)
            ->where('cover', 'general')
            ->orderBy('position');
    }

    // Performance optimization scopes
    public function scopePublished($query)
    {
        return $query->where('status', true)
                    ->where(function($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->where('status', true)
                    ->orderBy('views', 'desc')
                    ->limit($limit);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->where('status', true)
                    ->orderBy('created_at', 'desc')
                    ->limit($limit);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function($q) use ($categoryId) {
            $q->where('blog_categories.id', $categoryId);
        });
    }

    // Increment view count
    public function incrementViews()
    {
        $this->increment('views');
        $this->refresh();
    }

    public function coverStatusImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('position');
    }

    public function allImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('position', '>', 0)->orderBy('position');
    }

    public function allFiles(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '>', 0)
            ->where('type', 'document')  // Add the condition to filter by type
            ->orderBy('position');
    }
    public function folders(): MorphToMany
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }

    public function mainImage(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    public function mainImageShow()
    {
        $general = Cache::remember('generalArticle'.$this->id, self::CACHE_TTL, function (){
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
        $general = Cache::remember('statusImageShowArticle'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
            return $this->images()->where('cover', $status)->first();
        });
        if(is_object($general))
        {
            return $general->src;
        }else{
            return image_file_path($this->generalImage, '1200x630');
        }
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
