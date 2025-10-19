<x-layout :title="$car->brand . ' ' . $car->model . ' - Car Rent'">

    <x-slot name="head">
        <style>
            /* This style will highlight the active gallery thumbnail */
            .gallery-thumbnail.is-active {
                border-color: #111827; /* Black */
                opacity: 1;
            }
        </style>
    </x-slot>

    <main class="py-16 lg:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                    {{ $car->brand }} {{ $car->model }}
                </h1>
                <a href="{{ route('booking.create', $car) }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors mt-8">
                    Rent this Car for Rp {{ number_format($car->price_per_day) }}/day
                </a>
            </div>

            <div class="mt-12 lg:mt-16">
                <div class="w-full max-w-5xl mx-auto rounded-xl overflow-hidden shadow-2xl bg-gray-100">
                    <img id="main-car-image"
                         class="w-full h-auto object-cover transition-opacity duration-300"
                         src="{{ asset('storage/' . ($car->thumbnail->path ?? ($car->images->first()->path ?? 'https://placehold.co/1200x800/e2e8f0/2d3748?text=No+Image'))) }}"
                         alt="{{ $car->brand }} {{ $car->model }} main image">
                </div>

                @if($car->images->count() > 1)
                    <div class="flex justify-center space-x-3 md:space-x-4 mt-6">
                        @foreach ($car->images as $image)
                            <img class="gallery-thumbnail cursor-pointer h-20 w-28 md:h-24 md:w-36 object-cover rounded-lg border-2
                                        {{ ($car->thumbnail && $car->thumbnail->id === $image->id) || (!$car->thumbnail && $loop->first) ? 'is-active' : 'border-transparent opacity-70 hover:opacity-100' }}
                                        transition-all"
                                 src="{{ asset('storage/' . $image->path) }}"
                                 alt="Gallery thumbnail {{ $loop->iteration }}">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-16 lg:mt-20 max-w-5xl mx-auto">
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-8">Vehicle Specifications</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8 text-center border border-gray-200 rounded-lg p-8 shadow-sm">
                    <div>
                        <p class="text-xl font-semibold text-gray-900">{{ ucfirst($car->body_type) }}</p>
                        <span class="text-sm text-gray-500">Body Type</span>
                    </div>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">{{ ucfirst($car->transmission) }}</p>
                        <span class="text-sm text-gray-500">Transmission</span>
                    </div>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">{{ $car->seats }}</p>
                        <span class="text-sm text-gray-500">Seats</span>
                    </div>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">{{ ucfirst($car->fuel_type) }}</p>
                        <span class="text-sm text-gray-500">Fuel Type</span>
                    </div>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">{{ $car->year }}</p>
                        <span class="text-sm text-gray-500">Year</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const mainImage = document.getElementById('main-car-image');
                const thumbnails = document.querySelectorAll('.gallery-thumbnail');

                thumbnails.forEach(thumb => {
                    thumb.addEventListener('click', function () {
                        mainImage.style.opacity = 0; // Fade out
                        setTimeout(() => {
                            mainImage.src = this.src; // Change source
                            mainImage.style.opacity = 1; // Fade in
                        }, 150); // Match half the transition duration


                        thumbnails.forEach(t => {
                            t.classList.remove('is-active');
                            t.classList.add('border-transparent', 'opacity-70');
                        });

                        this.classList.add('is-active');
                        this.classList.remove('border-transparent', 'opacity-70');
                    });
                });
            });
        </script>
    </x-slot>

</x-layout>