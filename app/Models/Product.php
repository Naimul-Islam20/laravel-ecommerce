<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'slug',
        'image',
        'short_description',
        'description',
        'gallery',
        'pack_options',
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
        'is_paper_products',
        'is_new_arrivals',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_from' => 'decimal:2',
            'gallery' => 'array',
            'pack_options' => 'array',
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
            'is_paper_products' => 'boolean',
            'is_new_arrivals' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function homeSections(): BelongsToMany
    {
        return $this->belongsToMany(HomeSection::class)->withTimestamps();
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

    public function scopePaperProducts($query)
    {
        return $query->active()
            ->where('is_paper_products', true)
            ->orderBy('sort_order');
    }

    public function scopeNewArrivals($query)
    {
        return $query->active()
            ->where('is_new_arrivals', true)
            ->orderBy('sort_order');
    }

    public function imageUrl(): ?string
    {
        $path = $this->image ?: 'images/item-1.webp';

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset($path);
    }

    public function galleryUrls(): array
    {
        $urls = [$this->imageUrl()];

        foreach ($this->gallery ?? [] as $path) {
            if (! $path) {
                continue;
            }

            $url = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
                ? $path
                : asset($path);

            if (! in_array($url, $urls, true)) {
                $urls[] = $url;
            }
        }

        // Keep at least two thumbs on detail page when only one image exists.
        if (count($urls) === 1) {
            $urls[] = $urls[0];
        }

        return $urls;
    }

    public function packOptions(): array
    {
        if (! empty($this->pack_options)) {
            return $this->pack_options;
        }

        $base = max(1, (float) $this->price_from / 25);

        return [
            ['pcs' => 25, 'unit_price' => round($base, 2)],
            ['pcs' => 100, 'unit_price' => round($base * 0.94, 2)],
            ['pcs' => 300, 'unit_price' => round($base * 0.89, 2)],
            ['pcs' => 500, 'unit_price' => round($base * 0.87, 2)],
        ];
    }

    public function formattedPrice(float $amount): string
    {
        return $this->currency.' '.number_format($amount, 2);
    }

    public function formattedPriceFrom(): string
    {
        return 'From '.$this->currency.' '.number_format((float) $this->price_from, 2);
    }

    public function defaultShortDescription(): string
    {
        return $this->short_description
            ?: 'This tray contains 3 different compartments to segregate a variety of dry and liquid food. It is microwave & Freezer safe.';
    }

    public function defaultDescriptionHtml(): string
    {
        if ($this->description) {
            return $this->description;
        }

        return '<p><strong>'.$this->name.'</strong></p>'
            .'<p>Compact. Convenient. Classy.</p>'
            .'<p>Perfect for restaurants, cloud kitchens, catering, and takeaways. Durable build with a secure lid for mess-free packing and delivery.</p>';
    }
}
