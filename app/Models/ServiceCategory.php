<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Cache;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait, MenuTrait;

    public $table = 'service_categories';

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
        'src',
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

    public function services(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Service','service_cat','service_category_id','service_id');
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
}
