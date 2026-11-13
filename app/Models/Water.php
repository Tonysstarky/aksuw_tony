<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Water extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'volume', 'price', 'stock',
        'ph_level', 'mineral_content', 'image', 'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    // ─── Relationships ───
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // ─── Helpers ───
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format((float) $this->price, 2).' TMT';
    }

    /** Surat: URL (seeder), public/images/ ýa-da storage/public ýoly (ýüklenen) */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (Str::startsWith($this->image, ['/images/', 'images/'])) {
            return asset(ltrim($this->image, '/'));
        }

        return asset('storage/'.$this->image);
    }

    // ─── Validation ───
    public static function validationRules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'volume' => 'required|string|max:50',
            'price' => 'required|numeric|min:0.01|max:99999.99',
            'stock' => 'required|integer|min:0|max:1000000',
            'ph_level' => 'nullable|string|max:10',
            'mineral_content' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string|max:2000',
        ];
    }
}
