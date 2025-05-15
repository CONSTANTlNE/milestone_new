<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Cache;

class Media extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, MultiTranslatableTrait;

    public $table = 'medias';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'source',
        'links',
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
        'slug',
        'source',
        'links',
    ];

    protected static bool $logFillable = true;

    public function images()
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->orderBy('ord');
    }

    public function generalImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('ord', '<', 1)
            ->orderBy('ord');
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
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->orderBy('ord');
    }

    public function allImages()
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('ord', '>', 0)
            ->orderBy('ord');
    }

    public function folders()
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }

    public function mainImage()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    public function mainImageShow()
    {
        $general = Cache::remember('generalMedia'.$this->id, self::CACHE_TTL, function (){
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

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
