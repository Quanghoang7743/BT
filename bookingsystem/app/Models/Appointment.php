<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = ['customer_id', 'appointment_date', 'appointment_time'];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getDatetimeAttribute(): string
    {
        return $this->appointment_date->format('d/m/Y') . ' ' . substr($this->appointment_time, 0, 5);
    }

    public function isPast(): bool
    {
        $datetime = $this->appointment_date->format('Y-m-d') . ' ' . $this->appointment_time;
        return strtotime($datetime) < time();
    }
}
