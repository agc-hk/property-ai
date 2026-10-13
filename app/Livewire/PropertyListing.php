<?php

namespace App\Livewire;

use App\Models\Property;
use App\Services\PropertySearch;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class PropertyListing extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $city = '';

    #[Url]
    public string $type = '';

    #[Url]
    public string $listing_type = '';

    #[Url]
    public ?int $min_price = null;

    #[Url]
    public ?int $max_price = null;

    #[Url]
    public ?int $bedrooms = null;

    #[Url]
    public string $sort = 'newest';

    // reset to page 1 whenever a filter changes
    public function updated(string $name): void
    {
        if (! str_starts_with($name, 'paginators')) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'city', 'type', 'listing_type', 'min_price', 'max_price', 'bedrooms']);
        $this->sort = 'newest';
        $this->resetPage();
    }

    /**
     * @return LengthAwarePaginator<int, Property>
     */
    #[Computed]
    public function properties(): LengthAwarePaginator
    {
        return app(PropertySearch::class)->query([
            'q' => $this->search,
            'city' => $this->city,
            'type' => $this->type,
            'listing_type' => $this->listing_type,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'bedrooms' => $this->bedrooms,
            'sort' => $this->sort,
        ])->paginate(12);
    }

    /**
     * @return Collection<int, string>
     */
    #[Computed]
    public function cities(): Collection
    {
        return Property::query()->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
    }

    public function render(): View
    {
        return view('livewire.property-listing');
    }
}
