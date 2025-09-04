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
        'surcharges' => 'array',
    ];

    public function carbrand(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return   $this->hasMany(CarBrand::class);
    }

    public function carmodel(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return   $this->hasMany(CarModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sent_by_id');
    }
}
