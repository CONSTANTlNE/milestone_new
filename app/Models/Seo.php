<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class Seo extends Model
{
    use HasFactory, HasTranslations;

    public $table = 'seos';

    protected array $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'seoTitles' => 'array',
        'seoKeywords' => 'array',
        'seoDescriptions' => 'array',
    ];
    protected $fillable = [
        'seoTitles',
        'seoKeywords',
        'seoDescriptions',
        'model_id',
        'model_type',
        'created_at',
        'updated_at',
    ];

    public array $translatable = [
        'seoTitles',
        'seoKeywords',
        'seoDescriptions',
    ];

    protected static bool $logFillable = true;

    public function seoble(): MorphTo
    {
        return $this->morphTo();
    }
}

