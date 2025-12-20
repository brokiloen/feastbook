<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'name',
        'quantity',
        'unit',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
    ];

    public const UNITS = [
        'g' => 'grams',
        'kg' => 'kilograms',
        'ml' => 'milliliters',
        'L' => 'liters',
        'pcs' => 'pieces',
        'tbsp' => 'tablespoons',
        'tsp' => 'teaspoons',
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    public function getFormattedQuantityAttribute(): string
    {
        if ($this->quantity === null) {
            return '';
        }

        $qty = rtrim(rtrim(number_format($this->quantity, 2), '0'), '.');
        
        if ($this->unit) {
            return $qty . ' ' . $this->unit;
        }

        return $qty;
    }
}

