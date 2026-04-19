<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    protected $fillable = ['key', 'label', 'description', 'enabled', 'sort_order'];

    protected $casts = ['enabled' => 'boolean'];

    public static function enabledKeys(): array
    {
        return static::where('enabled', true)->orderBy('sort_order')->pluck('key')->all();
    }
}
