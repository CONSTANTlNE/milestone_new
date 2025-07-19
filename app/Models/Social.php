<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'socials';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'icon',
        'url',
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static bool $logFillable = true;

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
