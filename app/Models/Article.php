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
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;
//use Spatie\Searchable\Searchable;
//use Spatie\Searchable\SearchResult;

class Article extends Model
{
    use HasFactory, Searchable, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, TagTrait, MultiTranslatableTrait;

    public $table = 'articles';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $fillable = [
        'title',
        'slug',
        'slogan',
        'content',
        'status',
        'views',
        'user_id',
        'verdict_id',
        'verdict_versus_id',
        'option_id',
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

    // Specify searchable data
    public function toSearchableArray(): array
    {
//                    'title' => implode(' ', $this->getTranslations('title')),
        return [
            'title' => $this->title
        ];
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('frontend.story.index', [app()->getLocale(), 'id'=>$this->id, 'slug'=>$this->getTranslation('slug', app()->getLocale())]);

        return new SearchResult(
            $this,
            $this->title,
            $url
         );
    }
    public function seo(): MorphMany
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function reporter(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function versus(): HasMany
    {
        return $this->hasMany('App\Models\Versus', 'article_id');
    }

    public function verdict(): BelongsTo
    {
        return $this->belongsTo(Verdict::class);
    }
    public function verdictVersus(): BelongsTo
    {
        return $this->belongsTo(Verdict::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\ArticleCategory','article_categories','article_id','category_id');
    }

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Person','article_persons','article_id','person_id');
    }

    public function regions(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Region','article_regions','article_id','region_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Tag','article_tags','article_id','tag_id');
    }

    public function tagViews($langs): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tags', 'article_id', 'tag_id')
            ->whereIn('tags.lang', [$langs]);
    }

    public function images(): MorphToMany
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

    public function coverStatusImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('ord');
    }

    public function allImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('ord', '>', 0)->orderBy('ord');
    }

    public function allFiles(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('ord', '>', 0)
            ->where('type', 'document')  // Add the condition to filter by type
            ->orderBy('ord');
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

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
