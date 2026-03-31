<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['customer_name', 'status', 'total'];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateTotal(): void
    {
        $this->total = $this->items()->sum('subtotal');
        $this->save();
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => '#f59e0b',
            'processing' => '#3b82f6',
            'completed' => '#10b981',
            default => '#6b7280',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'completed' => 'Hoàn thành',
            default => $this->status,
        };
    }
}
