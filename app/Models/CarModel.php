<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    protected $table = 'car_models';

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class, 'car_brand_id');
    }

    public function quotations(): HasMany {
        return   $this->hasMany(Quotation::class);
    }


}
