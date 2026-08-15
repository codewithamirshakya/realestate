<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'listing_type',
        'category',
        'status',
        'price',
        'area_sqft',
        'bedrooms',
        'bathrooms',
        'parking',
        'address',
        'city',
        'latitude',
        'longitude',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'area_sqft' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Property $property): void {
            if (empty($property->slug)) {
                $property->slug = static::generateUniqueSlug($property->title);
            }
        });
    }

    public static function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$counter);
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<PropertyImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<Inquiry, $this>
     */
    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * @return HasMany<Favorite, $this>
     */
    public function favoritedBy(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function primaryImage(): ?PropertyImage
    {
        return $this->images->firstWhere('is_primary', true) ?? $this->images->first();
    }

    public function formattedPrice(): string
    {
        $amount = (float) $this->price;

        if ($amount >= 10000000) {
            return 'Rs. '.number_format($amount / 10000000, 2).' Crore';
        }

        if ($amount >= 100000) {
            return 'Rs. '.number_format($amount / 100000, 2).' Lakh';
        }

        return 'Rs. '.number_format($amount);
    }

    public function scopeSearch($query, ?string $term)
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('city', 'like', "%{$term}%")
                ->orWhere('address', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }
}
