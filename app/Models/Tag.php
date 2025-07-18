<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Tag extends Model
{
    public $table = 'tags';

    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'lang',
        'created_at',
        'updated_at'
    ];

    protected static bool $logFillable = true;

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Blog','article_tags','tag_id','article_id');
    }
}

