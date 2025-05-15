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
use Laravel\Scout\Searchable;
use Spatie\Translatable\HasTranslations;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class Person extends Model
{
    use HasFactory, Searchable, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait, MenuTrait;

    public $table = 'persons';
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
        'type',
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

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title
        ];
    }

    public function seo()
    {
        return $this->morphMany('App\Models\Seo','seoble');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Article','article_persons','person_id','article_id');
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

    public function statusImageShow($status)
    {
        $general = Cache::remember('statusImageShowPerson'.$this->id.'-'.$status, self::CACHE_TTL, function () use($status){
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
