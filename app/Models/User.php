<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\EscapeUniCodeJson;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, EscapeUniCodeJson, HasTranslations, SoftDeletes, MultiTranslatableTrait;

    protected $table = 'users';
    const CACHE_TTL = 86400; // 1 day

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'name',
        'status',
        'phone',
        'email',
        'password',
        'confirmation',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public array $translatable = [
        'title',
        'slug',
        'content',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'title' => 'array',
    ];

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany('App\Models\Blog', 'user_id');
    }

    public function images(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->orderBy('position');
    }

    public function generalImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '<', 1)
            ->orderBy('position');
    }

    public function generalImage(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '<', 1)
            ->where('cover', 'general')
            ->orderBy('position');
    }

    public function allImages(): MorphToMany
    {
        return $this->morphToMany(File::class, 'fileable')
            ->withPivot('cover')
            ->where('position', '>', 0)
            ->orderBy('position');
    }

    public function folders()
    {
        return $this->morphToMany(Folder::class, 'folderable');
    }

    public static function getNextPosition()
    {
        return static::max('position') !== null ? static::max('position') + 1 : 1;
    }
}
