<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use HasTranslations, EscapeUniCodeJson;
    public $table = 'menu_items';

    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'sort',
        'class',
        'menu_id',
        'depth',
        'model_id',
        'model_type',
        'status',
        'created_at',
        'updated_at',
    ];

    public array $translatable = [
        'title',
        'slug',
    ];

    protected static bool $logFillable = true;

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent(): Collection
    {
        return $this->hasMany('App\Models\MenuItem','parent_id','id')->orderBy('sort','desc')->get();
    }

    public function rowParent(): BelongsTo
    {
        return  $this->belongsTo('App\Models\MenuItem','parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('status', 1)
            ->with('children') // Recursive loading
            ->orderBy('sort', 'asc');
    }

    public function getSons($id)
    {
        return $this->where("parent_id", $id)->get();
    }
    public function getAll($id)
    {
        return $this->where("menu_id", $id)->orderBy("sort", "asc")->get();
    }

    public static function getNextSortRoot($menu)
    {
        return self::where('menu_id', $menu)->max('sort') + 1;
    }

    public function parentMenu()
    {
        return $this->belongsTo('App\Models\Menus', 'menu_id');
    }

    public function child()
    {
        return $this->hasMany('App\Models\MenuItems', 'parent_id')->orderBy('sort', 'ASC');
    }

}
