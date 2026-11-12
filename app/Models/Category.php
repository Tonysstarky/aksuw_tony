<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_tm', 'name_ru', 'name_en',
        'description_tm', 'description_ru', 'description_en',
        'icon',
    ];

    // ─── Relationship: bir kategoriýada köp suw ───
    public function waters(): HasMany
    {
        return $this->hasMany(Water::class);
    }

    // ─── Dile görä at we düşündiriş ($category->name) ───
    public function getNameAttribute(): string
    {
        $field = 'name_'.app()->getLocale();

        return $this->{$field} ?: $this->name_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        $field = 'description_'.app()->getLocale();

        return $this->{$field} ?: $this->description_en;
    }

    // ─── Validation ───
    public static function validationRules(): array
    {
        return [
            'name_tm' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_tm' => 'nullable|string|max:1000',
            'description_ru' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:10',
        ];
    }
}
