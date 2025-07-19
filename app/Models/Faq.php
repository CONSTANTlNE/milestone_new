<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use App\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, EscapeUniCodeJson, SeoTrait, MultiTranslatableTrait;

    public $table = 'faqs';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'service_id',
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

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
