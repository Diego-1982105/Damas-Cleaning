<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'service_type',
        'message',
        'status',
        'admin_notes',
        'seen_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'seen_at' => 'datetime',
        ];
    }

    /** Scope: leads the admin hasn't dismissed yet. */
    public function scopeUnseen(Builder $query): Builder
    {
        return $query->whereNull('seen_at');
    }

    /**
     * @return array<string, string>
     */
    public static function statusLabels(): array
    {
        return [
            'new' => 'New',
            'contacted' => 'Contacted',
            'quoted' => 'Quoted',
            'won' => 'Won',
            'lost' => 'Lost',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    /**
     * Si la estimación está ganada, refleja o crea el registro en el catálogo de clientes (mismo correo).
     */
    public function syncToClientWhenWon(): void
    {
        if ($this->status !== 'won') {
            return;
        }

        $email = Str::lower(trim($this->email));

        $client = Client::query()->whereRaw('LOWER(email) = ?', [$email])->first()
            ?? new Client(['email' => $this->email]);

        $isNew = ! $client->exists;

        $client->name = $this->name;

        if (filled($this->phone)) {
            $client->phone = $this->phone;
        }

        // Only fill address when creating a new client or when the client has none yet.
        if (filled($this->address) && ($isNew || blank($client->address))) {
            $client->address = $this->address;
        }

        $client->save();
    }
}
