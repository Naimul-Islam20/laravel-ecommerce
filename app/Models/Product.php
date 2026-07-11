<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
        'price_from',
        'currency',
        'is_best_seller',
        'is_top_selling',
        'is_hinged_box',
        'is_trending',
        'is_meal_trays',
        'is_round_containers',
        'is_rectangular_container',
        'is_cornstarch_product',
        'is_aluminium_foil_container',
        'is_bagasse_tableware',
        'is_biodegradable_products',
        'is_bagasse_takeaway_container',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_from' => 'decimal:2',
            'is_best_seller' => 'boolean',
            'is_top_selling' => 'boolean',
            'is_hinged_box' => 'boolean',
            'is_trending' => 'boolean',
            'is_meal_trays' => 'boolean',
            'is_round_containers' => 'boolean',
            'is_rectangular_container' => 'boolean',
            'is_cornstarch_product' => 'boolean',
            'is_aluminium_foil_container' => 'boolean',
            'is_bagasse_tableware' => 'boolean',
            'is_biodegradable_products' => 'boolean',
            'is_bagasse_takeaway_container' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBestSellers($query)
    {
        return $query->active()
            ->where('is_best_seller', true)
            ->orderBy('sort_order');
    }

    public function scopeTopSelling($query)
    {
        return $query->active()
            ->where('is_top_selling', true)
            ->orderBy('sort_order');
    }

    public function scopeHingedBox($query)
    {
        return $query->active()
            ->where('is_hinged_box', true)
            ->orderBy('sort_order');
    }

    public function scopeTrending($query)
    {
        return $query->active()
            ->where('is_trending', true)
            ->orderBy('sort_order');
    }

    public function scopeMealTrays($query)
    {
        return $query->active()
            ->where('is_meal_trays', true)
            ->orderBy('sort_order');
    }

    public function scopeRoundContainers($query)
    {
        return $query->active()
            ->where('is_round_containers', true)
            ->orderBy('sort_order');
    }

    public function scopeRectangularContainer($query)
    {
        return $query->active()
            ->where('is_rectangular_container', true)
            ->orderBy('sort_order');
    }

    public function scopeCornstarchProduct($query)
    {
        return $query->active()
            ->where('is_cornstarch_product', true)
            ->orderBy('sort_order');
    }

    public function scopeAluminiumFoilContainer($query)
    {
        return $query->active()
            ->where('is_aluminium_foil_container', true)
            ->orderBy('sort_order');
    }

    public function scopeBagasseTableware($query)
    {
        return $query->active()
            ->where('is_bagasse_tableware', true)
            ->orderBy('sort_order');
    }

    public function scopeBiodegradableProducts($query)
    {
        return $query->active()
            ->where('is_biodegradable_products', true)
            ->orderBy('sort_order');
    }

    public function scopeBagasseTakeawayContainer($query)
    {
        return $query->active()
            ->where('is_bagasse_takeaway_container', true)
            ->orderBy('sort_order');
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

    public function formattedPriceFrom(): string
    {
        return 'From '.$this->currency.' '.number_format((float) $this->price_from, 2);
    }
}
