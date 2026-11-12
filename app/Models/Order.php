<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'water_id',
        'quantity',
        'total_price',
        'status',
        'delivery_address',
        'phone',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function water(): BelongsTo
    {
        return $this->belongsTo(Water::class);
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public const STATUSES = ['pending', 'processing', 'delivered', 'cancelled'];

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '⏳',
            'processing' => '🔄',
            'delivered' => '✅',
            'cancelled' => '❌',
            default => '❓',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format((float) $this->total_price, 2).' TMT';
    }

    // ─── Validation Rules ────────────────────────────────────────

    public static function validationRules(): array
    {
        return [
            'water_id' => 'required|exists:waters,id',
            'quantity' => 'required|integer|min:1|max:1000',
            'delivery_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
