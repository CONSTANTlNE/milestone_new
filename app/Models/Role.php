<?php

namespace App\Models;

use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRoles;

class Role extends SpatieRoles
{
    use HasTranslations, SoftDeletes, EscapeUniCodeJson, MultiTranslatableTrait;

   	public $table = 'roles';
    protected $guard_name = 'web';

    protected $casts = [
        'title' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guard_name',
        'has_backend_access',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
    ];
    public function scopeFilter(Builder $query, Request $request): Builder
    {
        $locale = app()->getLocale();

        return $query
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%'])
                        ->orWhereRaw("name ILIKE ?", ['%' . $search . '%']);
                });
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('has_backend_access', $request->status);
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                in_array($request->input('sort_direction'), ['asc', 'desc']) ? $request->input('sort_direction') : 'desc'
            );
    }

    public function scopeFilterTrash(Builder $query, Request $request): Builder
    {
        $locale = app()->getLocale();

        return $query->onlyTrashed()
            ->when($request->filled('search'), function ($query) use ($request, $locale) {
                $search = $request->search;
                $query->where(function ($q) use ($search, $locale) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title->>? ILIKE ?", [$locale, '%' . $search . '%']);
                });
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                in_array($request->input('sort_direction'), ['asc', 'desc']) ? $request->input('sort_direction') : 'desc'
            );
    }
}
