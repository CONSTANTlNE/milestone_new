<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class PageTier extends Model
{
    use HasTranslations;
    public $table = 'page_tiers';

    protected $fillable = [
        'title',
        'content',
        'page_id',
    ];

    public array $translatable = [
        'title',
        'content',
    ];

    public function page(): BelongsTo{
        return $this->belongsTo(Page::class);
    }
}
