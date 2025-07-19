<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Quotation extends Model
{

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function carbrand(): BelongsTo {
        return   $this->hasMany(CarBrand::class);
    }

    public function carmodel(): BelongsTo {
        return   $this->hasMany(CarModel::class);
    }
}
