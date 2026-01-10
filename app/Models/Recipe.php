<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'instructions',
        'photo',
        'last_made',
        'servings',
    ];

    protected $casts = [
        'last_made' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recipe) {
            if (empty($recipe->slug)) {
                $recipe->slug = Str::slug($recipe->name);
            }
        });

        static::updating(function ($recipe) {
            if ($recipe->isDirty('name') && !$recipe->isDirty('slug')) {
                $recipe->slug = Str::slug($recipe->name);
            }
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }
}

