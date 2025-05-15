<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes;

    public $table = 'subscribers';
    const CACHE_TTL = 86400; // 1 day

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static $logFillable = true;
}
