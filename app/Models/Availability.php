<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Availability extends Model
{
    protected  $guarded=[];

    use HasTranslations;

    public array $translatable = ['title'];
}
