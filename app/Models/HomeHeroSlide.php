<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeroSlide extends Model
{
    protected $fillable = [
        'image',
        'alt_text',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function imageUrl(): string
    {
        return app(\App\Services\ProductImageService::class)
            ->url($this->image, 'images/hero-7.png') ?? asset('images/hero-7.png');
    }
}

