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

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'seoTitles',
        'seoKeywords',
        'seoDescriptions',
        'seoble_id',
        'seoble_type',
        'created_at',
        'updated_at',
    ];

    public $translatable = [
        'seoTitles',
        'seoKeywords',
        'seoDescriptions',
    ];

    protected static $logFillable = true;

    public function seoble(): MorphTo
    {
        return $this->morphTo();
    }
}

