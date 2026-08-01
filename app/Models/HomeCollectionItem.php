<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeCollectionItem extends Model
{
    protected $fillable = [
        'category_id',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function typeLabel(): string
    {
        return $this->category?->parent_id ? 'SubCategory' : 'Category';
    }

    public function displayName(): string
    {
        $category = $this->category;

        if (! $category) {
            return '—';
        }

        if ($category->parent) {
            return $category->parent->name.' › '.$category->name;
        }

        return $category->name;
    }
}
