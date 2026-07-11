<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
        'menu_column',
        'menu_row',
        'sort_order',
        'is_active',
        'show_on_home',
        'home_sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'show_on_home' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('sort_order');
    }

    /**
     * Category id plus active subcategory ids (for collection product listing).
     */
    public function collectionCategoryIds(): array
    {
        $ids = [$this->id];

        $childIds = $this->children()
            ->active()
            ->pluck('id')
            ->all();

        return array_values(array_unique(array_merge($ids, $childIds)));
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForMenu($query)
    {
        return $query->active()
            ->parents()
            ->with(['children' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->orderBy('menu_column')
            ->orderBy('menu_row')
            ->orderBy('sort_order');
    }

    public function scopeForHome($query)
    {
        return $query->active()
            ->parents()
            ->where('show_on_home', true)
            ->orderBy('home_sort_order');
    }

    public function imageUrl(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset($this->image);
    }
}
