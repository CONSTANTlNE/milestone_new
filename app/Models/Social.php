<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Social extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'socials';
    const CACHE_TTL = 86400; // 1 day

    protected array $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'icon',
        'url',
        'status',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static bool $logFillable = true;

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        $locale = app()->getLocale();

        return $query
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title ILIKE ?", ['%' . $search . '%']);
                });
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when(
                $request->filled('sort_column'),
                function ($q) use ($request) {
                    $q->orderBy(
                        $request->input('sort_column', 'id'),
                        in_array($request->input('sort_direction'), ['asc', 'desc']) ? $request->input('sort_direction') : 'desc'
                    );
                },
                function ($q) {
                    $q->orderBy('position', 'asc');
                }
            );
    }

    public function scopeFilterTrash(Builder $query, Request $request): Builder
    {
        $locale = app()->getLocale();

        return $query->onlyTrashed()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('CAST(id AS TEXT) ILIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw("title ILIKE ?", ['%' . $search . '%']);
                });
            })
            ->orderBy(
                $request->input('sort_column', 'id'),
                in_array($request->input('sort_direction'), ['asc', 'desc']) ? $request->input('sort_direction') : 'desc'
            );
    }
}
