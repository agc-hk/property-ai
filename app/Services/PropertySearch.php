<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PropertySearch
{
    public const SORTS = [
        'newest' => ['created_at', 'desc'],
        'price_asc' => ['price', 'asc'],
        'price_desc' => ['price', 'desc'],
        'area_desc' => ['area_sqft', 'desc'],
    ];

    /**
     * @param  array<string, mixed>  $f
     * @return Builder<Property>
     */
    public function query(array $f): Builder
    {
        [$col, $dir] = self::SORTS[$f['sort'] ?? 'newest'] ?? self::SORTS['newest'];

        $likeOp = DB::getDriverName() === 'pgsql' ? 'ilike' : 'like';

        return Property::query()
            ->when($f['q'] ?? null, fn ($q, $v) => $q->where(fn ($w) => $w
                ->where('title', $likeOp, "%$v%")
                ->orWhere('locality', $likeOp, "%$v%")
                ->orWhere('description', $likeOp, "%$v%")))
            ->when($f['city'] ?? null, fn ($q, $v) => $q->where('city', $likeOp, $v))
            ->when($f['type'] ?? null, fn ($q, $v) => $q->where('type', $v))
            ->when($f['listing_type'] ?? null, fn ($q, $v) => $q->where('listing_type', $v))
            ->when($f['min_price'] ?? null, fn ($q, $v) => $q->where('price', '>=', $v))
            ->when($f['max_price'] ?? null, fn ($q, $v) => $q->where('price', '<=', $v))
            ->when($f['bedrooms'] ?? null, fn ($q, $v) => $q->where('bedrooms', '>=', $v))
            ->orderBy($col, $dir);
    }

    /**
     * Used by chatbot and MCP: small, plain array result
     *
     * @param  array<string, mixed>  $f
     * @return array<int, array<string, mixed>>
     */
    public function search(array $f, int $limit = 5): array
    {
        return $this->query($f)
            ->limit($limit)
            ->get(['id', 'title', 'city', 'locality', 'type', 'listing_type', 'price', 'bedrooms', 'area_sqft'])
            ->toArray();
    }
}
