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

class Partner extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, MultiTranslatableTrait;

    public $table = 'partners';
    const CACHE_TTL = 86400; // 1 day

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'url',
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $translatable = [
        'title',
    ];

    protected static $logFillable = true;

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

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
