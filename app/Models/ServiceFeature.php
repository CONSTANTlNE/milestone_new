<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ServiceFeature extends Model
{
    use HasTranslations;
    public $table = 'availabilities';

    protected $fillable = [
        'title',
        'service_id',
    ];
    public array $translatable = ['title'];

    public function service(): BelongsTo{
        return $this->belongsTo(Service::class);
    }
}
