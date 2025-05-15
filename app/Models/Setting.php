<?php

namespace App\Models;

use App\Traits\MultiTranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations, MultiTranslatableTrait;

    public $table = 'settings';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'content',
        'status',
        'lat',
        'lng',
        'email',
        'mobile',
        'send_email',
        'g_map',
        'g_analytics',
        'created_at',
        'updated_at',
    ];

    public array $translatable = [
        'title',
        'content',
    ];

    protected static $logFillable = true;

    public function updateSettings($data): void
    {
        $this->setMultiTranslations($data);
        $this->fill($data);
        $this->status = 1; // Assuming you always want to set status to 1
        $this->save();
    }
}
