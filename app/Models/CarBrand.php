<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarBrand extends Model
{

    protected $table = 'car_brands';

    public function models(): HasMany {
        return $this->hasMany(CarModel::class);
    }

    public function quotations(): HasMany {
        return   $this->hasMany(Quotation::class);
    }
}
