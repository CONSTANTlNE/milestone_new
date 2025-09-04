<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuotationCharge extends Model
{
    protected $guarded=[];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($charge) {
            $charge->slug = Str::slug($charge->name);

            $originalSlug = $charge->slug;
            $i = 1;
            while (QuotationCharge::where('slug', $charge->slug)->exists()) {
                $charge->slug = $originalSlug . '-' . $i++;
            }
        });
    }
}
