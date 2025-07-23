<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotation extends Model
{

    protected  $guarded=[];

    protected $casts = [
        'created_at' => 'datetime',
        'specs_links' => 'array',
    ];

    public function carbrand(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return   $this->hasMany(CarBrand::class);
    }

    public function carmodel(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return   $this->hasMany(CarModel::class);
    }
}
