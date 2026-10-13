<?php

namespace Tests\Feature;

use App\Livewire\PropertyListing;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_listing_page_loads_successfully(): void
    {
        $response = $this->get('/properties');
        $response->assertOk();
    }

    public function test_property_listing_component_renders_and_filters_properties(): void
    {
        Property::factory()->create([
            'title' => 'Luxury Sea View Villa in Mumbai',
            'city' => 'Mumbai',
            'type' => 'villa',
            'listing_type' => 'sale',
            'price' => 50000000,
            'bedrooms' => 4,
        ]);

        Property::factory()->create([
            'title' => 'Compact 1 BHK Apartment in Pune',
            'city' => 'Pune',
            'type' => 'apartment',
            'listing_type' => 'rent',
            'price' => 25000,
            'bedrooms' => 1,
        ]);

        Livewire::test(PropertyListing::class)
            ->assertSee('Luxury Sea View Villa in Mumbai')
            ->assertSee('Compact 1 BHK Apartment in Pune')
            // Filter by city
            ->set('city', 'Mumbai')
            ->assertSee('Luxury Sea View Villa in Mumbai')
            ->assertDontSee('Compact 1 BHK Apartment in Pune')
            // Filter by listing type
            ->set('city', '')
            ->set('listing_type', 'rent')
            ->assertSee('Compact 1 BHK Apartment in Pune')
            ->assertDontSee('Luxury Sea View Villa in Mumbai')
            // Reset filters
            ->call('resetFilters')
            ->assertSee('Luxury Sea View Villa in Mumbai')
            ->assertSee('Compact 1 BHK Apartment in Pune');
    }
}
