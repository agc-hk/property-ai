<?php

namespace App\Models;

use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @use HasFactory<PropertyFactory>
 */
class Property extends Model
{
    /** @use HasFactory<PropertyFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['amenities' => 'array'];

    /**
     * @return HasMany<Document, $this>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    // Indian-style price label: 45.5 L, 1.2 Cr, rent per month
    public function getPriceLabelAttribute(): string
    {
        $p = $this->price;
        $label = $p >= 10000000 ? '₹'.round($p / 10000000, 2).' Cr'
            : ($p >= 100000 ? '₹'.round($p / 100000, 2).' L' : '₹'.number_format($p));

        return $this->listing_type === 'rent' ? $label.'/mo' : $label;
    }
}
