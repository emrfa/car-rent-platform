<x-layout title="Explore Our Vehicles - Car Rent" bodyClass="bg-gray-50">

    <!-- Page-specific styles for the filter buttons -->
    <x-slot name="head">
        <style>
            .filter-btn.active {
                background-color: #111827; /* Black */
                color: #ffffff; /* White */
            }
        </style>
    </x-slot>

    <!-- Main Content -->
    <main class="py-16 lg:py-24 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="max-w-3xl mx-auto text-center mb-12">
                @if(request('search'))
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                        Search Results
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Showing results for: <span class="font-semibold text-gray-900">"{{ request('search') }}"</span>
                    </p>
                    <a href="{{ route('cars.index', ['body_type' => $currentFilter]) }}" class="mt-4 inline-block text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                        &times; Clear Search
                    </a>
                @else
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                        Explore Our Vehicles
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Find the perfect car for your next journey.
                    </p>
                @endif
            </div>

            <!-- Search Form -->
            <form action="{{ route('cars.index') }}" method="GET" class="w-full max-w-lg mx-auto mb-12">
                <input type="hidden" name="body_type" value="{{ $currentFilter }}">
                <div class="relative">
                    <input type="text"
                           name="search"
                           placeholder="Search by car, brand, or type..."
                           value="{{ request('search') }}"
                           class="w-full bg-white text-gray-900 placeholder-gray-500 border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 rounded-lg shadow-sm py-3 pl-5 pr-12">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-12">
                @php
                    $filters = ['all', 'sedan', 'suv', 'mpv', 'hatchback'];
                @endphp

                @foreach($filters as $filter)
                    <a href="{{ route('cars.index', ['body_type' => $filter, 'search' => request('search')]) }}"
                       class="filter-btn font-semibold px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 transition-colors {{ $currentFilter == $filter ? 'active' : '' }}">
                        {{ ucfirst($filter) }}
                    </a>
                @endforeach
            </div>

            <!-- Car Grid -->
            @if($cars->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($cars as $car)
                        <div class="group relative rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                            <a href="{{ route('cars.show', $car) }}">
                                @if($car->thumbnail)
                                    <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $car->thumbnail->path) }}" alt="{{ $car->brand }} {{ $car->model }}">
                                @elseif($car->images->isNotEmpty())
                                    <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $car->images->first()->path) }}" alt="{{ $car->brand }} {{ $car->model }}">
                                @else
                                    <img class="h-64 w-full object-cover" src="https://placehold.co/600x400/e2e8f0/2d3748?text=No+Image" alt="No image available">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <div class="transform transition-transform duration-300 group-hover:-translate-y-8">
                                        <h3 class="text-xl font-bold text-white">{{ $car->brand }} {{ $car->model }}</h3>
                                        <p class="text-sm text-gray-300">{{ ucfirst($car->transmission) }} • {{ $car->seats }} Seats</p>
                                    </div>
                                    <div class="absolute -bottom-10 left-6 opacity-0 transform transition-all duration-300 group-hover:bottom-6 group-hover:opacity-100">
                                        <p class="text-lg font-bold text-white whitespace-nowrap">Rp {{ number_format($car->price_per_day) }}/day</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="mt-16">
                    {{ $cars->links() }}
                </div>

            @else
                <!-- No Cars Found Message -->
                <div class="text-center max-w-lg mx-auto bg-white p-10 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-2xl font-semibold text-gray-900">No Cars Found</h3>
                    <p class="mt-2 text-gray-600">We couldn't find any cars matching your search or filter. Try adjusting your terms or clearing the filter.</p>
                    <a href="{{ route('cars.index') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors mt-6">
                        Clear All Filters
                    </a>
                </div>
            @endif

        </div>
    </main>

</x-layout>