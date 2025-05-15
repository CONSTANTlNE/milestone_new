<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRoles;

class Role extends SpatieRoles
{
    use HasTranslations, SoftDeletes, EscapeUniCodeJson, MultiTranslatableTrait;

   	public $table = 'roles';
    protected $guard_name = 'web';

    public array $translatable = [
        'title',
    ];

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
