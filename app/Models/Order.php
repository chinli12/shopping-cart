<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property float $total_amount
 * @property float $tax
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $items
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'total_amount',
        'tax',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateTotal()
    {
        $subtotal = $this->orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $this->tax = $subtotal * 0.08;
        $this->total = $subtotal + $this->tax;
    }
}
