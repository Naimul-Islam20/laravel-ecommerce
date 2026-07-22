<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class HomeSection extends Model
{
    public const TYPE_CATEGORY = 'category';

    public const TYPE_SUBCATEGORY = 'subcategory';

    public const TYPE_FLAG = 'flag';

    protected $fillable = [
        'title',
        'slug',
        'type',
        'category_id',
        'product_flag',
        'product_limit',
        'sort_order',
        'is_active',
        'show_view_all',
        'grid_columns',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'show_view_all' => 'boolean',
            'grid_columns' => 'integer',
            'product_limit' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function flaggedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeFlagType($query)
    {
        return $query->where('type', self::TYPE_FLAG);
    }

    public function isCategoryType(): bool
    {
        return $this->type === self::TYPE_CATEGORY;
    }

    public function isSubcategoryType(): bool
    {
        return $this->type === self::TYPE_SUBCATEGORY;
    }

    public function isCatalogType(): bool
    {
        return $this->isCategoryType() || $this->isSubcategoryType();
    }

    public function isFlagType(): bool
    {
        return $this->type === self::TYPE_FLAG;
    }

    public function products(): Collection
    {
        if ($this->isCatalogType()) {
            return $this->categoryProducts();
        }

        if ($this->isFlagType()) {
            return $this->flagProducts();
        }

        return collect();
    }

    public function viewAllHref(): ?string
    {
        if (! $this->show_view_all) {
            return null;
        }

        if ($this->isCatalogType() && $this->category) {
            return route('collections.show', $this->category->slug);
        }

        if ($this->isFlagType()) {
            return route('collections.show', $this->slug);
        }

        return null;
    }

    public function gridClass(): string
    {
        $columns = (int) $this->grid_columns;

        return match ($columns) {
            4 => 'best-sellers-grid best-sellers-grid--4',
            5 => 'best-sellers-grid best-sellers-grid--5',
            6 => 'best-sellers-grid best-sellers-grid--6',
            default => 'best-sellers-grid',
        };
    }

    private function categoryProducts(): Collection
    {
        $category = $this->category;

        if (! $category) {
            return collect();
        }

        $categoryIds = $category->collectionCategoryIds();

        return Product::query()
            ->active()
            ->whereIn('category_id', $categoryIds)
            ->latest()
            ->limit($this->product_limit)
            ->get();
    }

    private function flagProducts(): Collection
    {
        return $this->flaggedProducts()
            ->active()
            ->latest()
            ->limit($this->product_limit)
            ->get();
    }
}
