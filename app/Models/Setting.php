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
        'working_hours',
        'address',
        'phone',
        'phone1',
        'email',
        'email1',
        'send_email',
        'lat',
        'lng',
        'g_map',
        'g_analytics',
        'fb_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public array $translatable = [
        'title',
        'working_hours',
        'address',
    ];

    protected static bool $logFillable = true;

    public function updateSettings($data): void
    {
        $this->setMultiTranslations($data);
        $this->fill($data);
        $this->save();
    }
}
