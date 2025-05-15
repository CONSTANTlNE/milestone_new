<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class ArticleCategory extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait, MenuTrait;

    public $table = 'categories';

    const CACHE_TTL = 86400; // 1 day

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'parent_id',
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
        'content',
    ];

    protected static bool $logFillable = true;

    public function seo(): MorphMany
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Article','article_categories','category_id','article_id');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->orderBy('ord');
    }

    public function generalImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('ord', '<', 1)->orderBy('ord');
    }

    public function allImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')->withPivot('cover')->where('ord', '>', 0)->orderBy('ord');
    }

    public function folders(): MorphToMany
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }

    public function parent(): Collection
    {
        return $this->hasMany('App\Models\ArticleCategory','parent_id','id')->orderBy('position','asc')->get();
    }

    public function children()
    {
        return $this->hasMany('App\Models\ArticleCategory', 'parent_id');
    }

    public function rowParent(): BelongsTo
    {
        return  $this->belongsTo('App\Models\ArticleCategory','parent_id');
    }

    public function generalImage(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('ord', '<', 1)
            ->where('cover', 'general')
            ->orderBy('ord');
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
}
