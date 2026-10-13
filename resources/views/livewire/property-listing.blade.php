<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Explore Premium Properties
            </h1>
            <p class="mt-2 text-base text-slate-600">
                Browse through vetted houses, apartments, villas, and commercial spaces across top locations.
            </p>
        </div>

        <!-- Filter & Search Panel -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-200/80 mb-8 space-y-5">
            <!-- Top Row: Search & Listing Type -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                <!-- Search Bar -->
                <div class="lg:col-span-8 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by title, locality, description..."
                        class="w-full pl-10 pr-10 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/80 focus:bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    />
                    @if($search)
                        <button
                            wire:click="$set('search', '')"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Listing Type (Sale / Rent) -->
                <div class="lg:col-span-4 flex items-center bg-slate-100 p-1 rounded-xl">
                    <button
                        type="button"
                        wire:click="$set('listing_type', '')"
                        class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all {{ $listing_type === '' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                    >
                        All Listings
                    </button>
                    <button
                        type="button"
                        wire:click="$set('listing_type', 'sale')"
                        class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all {{ $listing_type === 'sale' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                    >
                        For Sale
                    </button>
                    <button
                        type="button"
                        wire:click="$set('listing_type', 'rent')"
                        class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all {{ $listing_type === 'rent' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
                    >
                        For Rent
                    </button>
                </div>
            </div>

            <!-- Second Row: Multi-Filters -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3.5">
                <!-- City Filter -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">City</label>
                    <select
                        wire:model.live="city"
                        class="w-full py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    >
                        <option value="">All Cities</option>
                        @foreach($this->cities as $c)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Property Type -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Property Type</label>
                    <select
                        wire:model.live="type"
                        class="w-full py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    >
                        <option value="">All Types</option>
                        <option value="apartment">Apartment</option>
                        <option value="house">House</option>
                        <option value="villa">Villa</option>
                        <option value="plot">Plot</option>
                        <option value="commercial">Commercial</option>
                    </select>
                </div>

                <!-- Bedrooms Filter -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Bedrooms (Min)</label>
                    <select
                        wire:model.live="bedrooms"
                        class="w-full py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    >
                        <option value="">Any BHK</option>
                        <option value="1">1+ BHK</option>
                        <option value="2">2+ BHK</option>
                        <option value="3">3+ BHK</option>
                        <option value="4">4+ BHK</option>
                        <option value="5">5+ BHK</option>
                    </select>
                </div>

                <!-- Price Min -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Min Price (₹)</label>
                    <input
                        type="number"
                        wire:model.live.debounce.400ms="min_price"
                        placeholder="e.g. 2000000"
                        class="w-full py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    />
                </div>

                <!-- Price Max -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Max Price (₹)</label>
                    <input
                        type="number"
                        wire:model.live.debounce.400ms="max_price"
                        placeholder="e.g. 15000000"
                        class="w-full py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    />
                </div>
            </div>

            <!-- Third Row: Active Filter Badges & Sort -->
            <div class="flex flex-wrap items-center justify-between pt-2 border-t border-slate-100 gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs text-slate-500">Active filters:</span>
                    @if(!$search && !$city && !$type && !$listing_type && !$min_price && !$max_price && !$bedrooms)
                        <span class="text-xs text-slate-400 italic">None</span>
                    @endif

                    @if($search)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                            Query: {{ $search }}
                            <button wire:click="$set('search', '')" class="hover:text-indigo-900">&times;</button>
                        </span>
                    @endif

                    @if($city)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                            City: {{ $city }}
                            <button wire:click="$set('city', '')" class="hover:text-indigo-900">&times;</button>
                        </span>
                    @endif

                    @if($type)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                            Type: {{ ucfirst($type) }}
                            <button wire:click="$set('type', '')" class="hover:text-indigo-900">&times;</button>
                        </span>
                    @endif

                    @if($listing_type)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                            {{ $listing_type === 'sale' ? 'For Sale' : 'For Rent' }}
                            <button wire:click="$set('listing_type', '')" class="hover:text-indigo-900">&times;</button>
                        </span>
                    @endif

                    @if($bedrooms)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                            {{ $bedrooms }}+ Beds
                            <button wire:click="$set('bedrooms', null)" class="hover:text-indigo-900">&times;</button>
                        </span>
                    @endif

                    @if($min_price || $max_price)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                            Price: ₹{{ $min_price ? number_format($min_price) : '0' }} - {{ $max_price ? '₹'.number_format($max_price) : 'Any' }}
                            <button wire:click="$set('min_price', null); $set('max_price', null);" class="hover:text-indigo-900">&times;</button>
                        </span>
                    @endif

                    @if($search || $city || $type || $listing_type || $min_price || $max_price || $bedrooms)
                        <button
                            wire:click="resetFilters"
                            class="text-xs font-medium text-rose-600 hover:text-rose-700 hover:underline ml-1"
                        >
                            Reset all
                        </button>
                    @endif
                </div>

                <!-- Sort Dropdown -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500 whitespace-nowrap">Sort by:</span>
                    <select
                        wire:model.live="sort"
                        class="py-1.5 px-3 text-xs font-medium bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                        <option value="newest">Newest Listed</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="area_desc">Area: Largest First</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Property Results Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="text-sm text-slate-600">
                Found <span class="font-bold text-slate-900">{{ $this->properties->total() }}</span> properties
            </div>

            <!-- Loading indicator -->
            <div wire:loading class="text-xs text-indigo-600 font-medium flex items-center gap-1.5">
                <svg class="animate-spin h-3.5 w-3.5" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Updating results...
            </div>
        </div>

        <!-- Property Cards Grid -->
        @if($this->properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($this->properties as $property)
                    <div class="group bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 flex flex-col">
                        <!-- Card Header Image/Banner Area -->
                        <div class="relative h-48 bg-gradient-to-tr from-slate-800 to-indigo-950 p-4 flex flex-col justify-between overflow-hidden">
                            <!-- Background pattern/ambient glow -->
                            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>

                            <!-- Top Badges -->
                            <div class="relative z-10 flex items-center justify-between">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full uppercase tracking-wider backdrop-blur-md {{ $property->listing_type === 'sale' ? 'bg-emerald-500/85 text-white' : 'bg-indigo-500/85 text-white' }}">
                                    For {{ ucfirst($property->listing_type) }}
                                </span>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full uppercase tracking-wider bg-white/20 text-white backdrop-blur-md">
                                    {{ ucfirst($property->type) }}
                                </span>
                            </div>

                            <!-- Bottom Price on Hero Banner -->
                            <div class="relative z-10">
                                <div class="text-2xl font-extrabold text-white tracking-tight drop-shadow-sm">
                                    {{ $property->price_label }}
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <!-- Title -->
                                <h3 class="font-bold text-slate-900 text-lg leading-snug group-hover:text-indigo-600 transition-colors line-clamp-1">
                                    {{ $property->title }}
                                </h3>

                                <!-- Locality & City -->
                                <p class="mt-1 text-sm text-slate-500 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ $property->locality ? $property->locality . ', ' : '' }}{{ $property->city }}</span>
                                </p>

                                <!-- Specs Chips (Bedrooms, Bathrooms, Sqft) -->
                                <div class="mt-4 grid grid-cols-3 gap-2 py-3 px-2.5 bg-slate-50 rounded-xl text-center border border-slate-100">
                                    <div class="flex flex-col items-center">
                                        <span class="text-xs text-slate-400 font-medium">Beds</span>
                                        <span class="text-xs font-bold text-slate-800">{{ $property->bedrooms ?? '-' }} BHK</span>
                                    </div>
                                    <div class="flex flex-col items-center border-x border-slate-200">
                                        <span class="text-xs text-slate-400 font-medium">Baths</span>
                                        <span class="text-xs font-bold text-slate-800">{{ $property->bathrooms ?? '-' }}</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <span class="text-xs text-slate-400 font-medium">Area</span>
                                        <span class="text-xs font-bold text-slate-800">{{ $property->area_sqft ? number_format($property->area_sqft) . ' sqft' : '-' }}</span>
                                    </div>
                                </div>

                                <!-- Amenities -->
                                @if(!empty($property->amenities) && is_array($property->amenities))
                                    <div class="mt-3 flex flex-wrap gap-1.5">
                                        @foreach(array_slice($property->amenities, 0, 3) as $amenity)
                                            <span class="px-2 py-0.5 text-[11px] font-medium bg-slate-100 text-slate-600 rounded-md capitalize">
                                                {{ $amenity }}
                                            </span>
                                        @endforeach
                                        @if(count($property->amenities) > 3)
                                            <span class="px-1.5 py-0.5 text-[11px] font-medium bg-slate-100 text-slate-400 rounded-md">
                                                +{{ count($property->amenities) - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Card Action Footer -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-400">
                                    Listed {{ $property->created_at->diffForHumans() }}
                                </span>
                                <button class="px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:text-white bg-indigo-50 hover:bg-indigo-600 rounded-lg transition-all duration-200">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $this->properties->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">No properties matched your criteria</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Try adjusting your filters, clearing your search terms, or checking back later for new listings.
                </p>
                <div class="mt-6">
                    <button
                        wire:click="resetFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition-all"
                    >
                        Clear All Filters
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- Floating AI Chatbot Widget --}}
    <livewire:chat />
</div>
