<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, MultiTranslatableTrait;

    public $table = 'sliders';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'slogan',
        'url',
        'content',
        'status',
        'src',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
        'content',
        'slug',
        'slogan',
        'url'
    ];

    protected static bool $logFillable = true;

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

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
