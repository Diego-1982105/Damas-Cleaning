<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'date',
        'total',
        'status',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'total' => 'decimal:2',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function statusLabels(): array
    {
        return [
            'draft' => 'Draft',
            'sent' => 'Sent',
            'paid' => 'Paid',
            'cancelled' => 'Cancelled',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    /** Tailwind classes for the status pill badge. */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'paid' => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
            'sent' => 'bg-sky-100 text-sky-800 ring-sky-200',
            'cancelled' => 'bg-red-100 text-red-700 ring-red-200',
            default => 'bg-slate-100 text-slate-600 ring-slate-200',
        };
    }

    /**
     * @return BelongsTo<Client, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return HasMany<InvoiceItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function recalculateTotal(): void
    {
        $sum = (string) $this->items()->sum('total');
        $this->forceFill(['total' => $sum])->saveQuietly();
    }
}
