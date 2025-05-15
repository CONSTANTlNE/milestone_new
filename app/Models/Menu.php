<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes, EscapeUniCodeJson;

    public $table = 'menus';

    const CACHE_TTL = 86400; // 1 day

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static $logFillable = true;

    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }

    public function items(): HasMany
    {
        return $this->hasMany('App\Models\MenuItem', 'menu_id')
            ->with('child')
            ->where('parent_id', 0)
            ->orderBy('sort', 'ASC');
    }
}
