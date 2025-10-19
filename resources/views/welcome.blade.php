<x-layout title="Car Rent - Your Journey, Your Choice">

    <x-slot name="head">
        <style>
            .slideshow-image {
                transition: opacity 1.5s ease-in-out;
            }
            .text-shadow-custom {
                text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            }
            /* Styles for the scroll animation on individual cards */
            .reveal-card {
                opacity: 0;
                transform: translateY(50px);
                transition: opacity 0.6s ease-out, transform 0.6s ease-out;
            }
            .reveal-card.is-visible {
                opacity: 1;
                transform: translateY(0);
            }
            /* Style for the active filter button */
            .filter-btn.active {
                background-color: #111827; /* Black */
                color: #ffffff; /* White */
            }
        </style>
    </x-slot>

    <div class="absolute inset-0 -z-20">
        @if ($slideshowCars->isNotEmpty())
            @foreach ($slideshowCars as $index => $car)
                @if ($car->thumbnail)
                    <div class="slideshow-image absolute inset-0 bg-cover bg-center {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                         style="background-image: url('{{ asset('storage/' . $car->thumbnail->path) }}');">
                    </div>
                @endif
            @endforeach
        @else
            <div class="absolute inset-0 bg-gray-900"></div>
        @endif
    </div>

    <div class="absolute inset-0 bg-black/50 -z-10"></div>

    <div class="relative text-white min-h-[calc(100vh-68px)]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <header class="flex flex-col items-center justify-center text-center h-[60vh] md:h-[70vh]">
                <h1 class="text-3xl md:text-5xl font-bold leading-tight max-w-3xl text-shadow-custom">Your Journey, Your Choice. Unforgettable Drives Await.</h1>
                <p class="mt-4 text-base text-gray-200 max-w-2xl">Find the perfect vehicle for your next adventure, from luxury sedans to spacious SUVs.</p>
                <form action="{{ route('cars.index') }}" method="GET" class="mt-8 w-full max-w-lg">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search by car, brand, or type..." class="w-full bg-white text-gray-900 placeholder-gray-500 border border-gray-200 focus:border-gray-900 focus:ring-1 focus:ring-gray-900 rounded-lg shadow-sm py-3 pl-5 pr-12">
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </header>
        </div>
    </div>

    <section class="bg-white py-20 border-t border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Explore Our Vehicles</h2>

            <div id="filter-container" class="flex justify-center space-x-2 md:space-x-4 mb-12">
                <button class="filter-btn active font-semibold px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 transition-colors" data-filter="all">All</button>
                <button class="filter-btn font-semibold px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 transition-colors" data-filter="sedan">Sedan</button>
                <button class="filter-btn font-semibold px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 transition-colors" data-filter="suv">SUV</button>
                <button class="filter-btn font-semibold px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 transition-colors" data-filter="mpv">MPV</button>
                <button class="filter-btn font-semibold px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-100 transition-colors" data-filter="hatchback">Hatchback</button>
            </div>

            <div id="car-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($slideshowCars->take(6) as $car)
                    <div class="car-card reveal-card group relative rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300" data-type="{{ $car->body_type }}">
                        <a href="{{ route('cars.show', $car) }}">
                            @if($car->thumbnail)
                                <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $car->thumbnail->path) }}" alt="{{ $car->brand }} {{ $car->model }}">
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
                @empty
                    <p class="col-span-full text-center text-gray-500">No featured cars available at the moment.</p>
                @endforelse
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('cars.index') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors">
                    Show All Cars
                </a>
            </div>
        </div>
    </section>

    <section class="bg-white py-20 border-t border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">The Car Rent Advantage: What Sets Us Apart</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Experience the difference with a rental service built on trust, quality, and your satisfaction.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Our Strengths</h3>
                <h3 class="text-2xl font-bold text-gray-800">Avoid These Common Concerns</h3>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">

                <div class="reveal-card bg-blue-50 p-6 rounded-lg shadow-sm border border-blue-200 h-full">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600">
                            <x-heroicon-o-check-circle class="h-6 w-6" />
                        </div>
                        <h4 class="ml-4 text-xl font-bold text-gray-900">Transparent & Fair Pricing</h4>
                    </div>
                    <p class="text-gray-700">No hidden fees, no surprises. What you see is what you pay, ensuring you always get the best value.</p>
                </div>
                <div class="reveal-card bg-gray-100 p-6 rounded-lg shadow-sm border border-gray-200 h-full" style="transition-delay: 50ms;">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-600">
                            <x-heroicon-o-x-circle class="h-6 w-6" />
                        </div>
                        <h4 class="ml-4 text-xl font-bold text-gray-900">Hidden Fees & Unexpected Charges</h4>
                    </div>
                    <p class="text-gray-700">Many services surprise you with extra costs. We believe in clear, upfront pricing.</p>
                </div>

                <div class="reveal-card bg-blue-50 p-6 rounded-lg shadow-sm border border-blue-200 h-full" style="transition-delay: 100ms;">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600">
                           <x-heroicon-o-truck class="h-6 w-6" />
                        </div>
                        <h4 class="ml-4 text-xl font-bold text-gray-900">Modern & Well-Maintained Fleet</h4>
                    </div>
                    <p class="text-gray-700">Drive with confidence in our diverse range of new and regularly serviced vehicles.</p>
                </div>
                <div class="reveal-card bg-gray-100 p-6 rounded-lg shadow-sm border border-gray-200 h-full" style="transition-delay: 150ms;">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-600">
                           <x-heroicon-o-wrench-screwdriver class="h-6 w-6" />
                        </div>
                        <h4 class="ml-4 text-xl font-bold text-gray-900">Outdated or Poorly Maintained Cars</h4>
                    </div>
                    <p class="text-gray-700">Risking breakdowns with older vehicles can ruin your trip. We prioritize safety and comfort.</p>
                </div>

                <div class="reveal-card bg-blue-50 p-6 rounded-lg shadow-sm border border-blue-200 h-full" style="transition-delay: 200ms;">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600">
                            <x-heroicon-o-chat-bubble-bottom-center-text class="h-6 w-6" />
                        </div>
                        <h4 class="ml-4 text-xl font-bold text-gray-900">Exceptional Customer Support</h4>
                    </div>
                    <p class="text-gray-700">Our friendly and knowledgeable team is available 24/7 to assist you every step of the way.</p>
                </div>
                <div class="reveal-card bg-gray-100 p-6 rounded-lg shadow-sm border border-gray-200 h-full" style="transition-delay: 250ms;">
                    <div class="flex items-center mb-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 text-gray-600">
                            <x-heroicon-o-phone-x-mark class="h-6 w-6" />
                        </div>
                        <h4 class="ml-4 text-xl font-bold text-gray-900">Unresponsive Customer Service</h4>
                    </div>
                    <p class="text-gray-700">Getting help when you need it is crucial. Avoid services that leave you stranded.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="bg-white py-20 border-t border-gray-200 scroll-mt-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-20">Start Your Rental in 4 Easy Steps</h2>

            <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                 <div class="hidden lg:block absolute top-8 left-0 right-0 h-0.5">
                    <div class="absolute left-0 right-0 mx-auto top-1/2 -translate-y-1/2 border-t-2 border-dashed border-gray-300 w-3/4"></div>
                </div>

                <div class="reveal-card text-center z-10">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto mb-6 bg-blue-100 rounded-full border-4 border-gray-50 shadow-sm">
                        <x-heroicon-o-magnifying-glass class="h-8 w-8 text-blue-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">1. Find Your Car</h3>
                    <p class="mt-2 text-gray-600">Search our fleet and find your perfect ride.</p>
                </div>

                <div class="reveal-card text-center z-10" style="transition-delay: 150ms;">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto mb-6 bg-blue-100 rounded-full border-4 border-gray-50 shadow-sm">
                        <x-heroicon-o-calendar-days class="h-8 w-8 text-blue-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">2. Select Dates</h3>
                    <p class="mt-2 text-gray-600">Pick your dates for instant pricing.</p>
                </div>

                <div class="reveal-card text-center z-10" style="transition-delay: 300ms;">
                   <div class="flex items-center justify-center h-16 w-16 mx-auto mb-6 bg-blue-100 rounded-full border-4 border-gray-50 shadow-sm">
                        <x-heroicon-o-credit-card class="h-8 w-8 text-blue-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">3. Confirm & Pay</h3>
                    <p class="mt-2 text-gray-600">Securely pay through our gateway.</p>
                </div>

                <div class="reveal-card text-center z-10" style="transition-delay: 450ms;">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto mb-6 bg-blue-100 rounded-full border-4 border-gray-50 shadow-sm">
                        <x-heroicon-o-key class="h-8 w-8 text-blue-600" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">4. Hit the Road</h3>
                    <p class="mt-2 text-gray-600">You're all set! Enjoy your journey.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-20 border-t border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Visit Our Office</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">We're conveniently located in the heart of the city. Stop by to chat with our team or see our vehicles in person.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="reveal-card h-96 rounded-lg overflow-hidden shadow-xl border border-gray-200">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6664273574033!2d106.82224357590812!3d-6.175392393812255!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e764b12d%3A0x3d2ad6e1e0e9bcc8!2sMerdeka%20Palace!5e0!3m2!1sen!2sid!4v1729260142398!5m2!1sen!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="reveal-card" style="transition-delay: 150ms;">
                    <div class="bg-gray-50 p-8 rounded-lg border border-gray-200">
                         <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Location</h3>
                         <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <x-heroicon-o-map-pin class="h-6 w-6 text-gray-500" />
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-800">Location</h4>
                                    <p class="text-gray-600">Gambir, Central Jakarta City<br>Jakarta 10110, Indonesia</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <x-heroicon-o-phone class="h-6 w-6 text-gray-500" />
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-800">Call Us</h4>
                                    <p class="text-gray-600">+62 21 1234 5678</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <x-heroicon-o-envelope class="h-6 w-6 text-gray-500" />
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-800">Email Us</h4>
                                    <p class="text-gray-600">support@carrent.com</p>
                                </div>
                            </div>
                             <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <x-heroicon-o-clock class="h-6 w-6 text-gray-500" />
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-gray-800">Opening Hours</h4>
                                    <p class="text-gray-600">Mon - Sat: 08:00 - 20:00<br>Sun: 09:00 - 18:00</p>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Slideshow logic
                const images = document.querySelectorAll('.slideshow-image');
                if (images.length > 1) {
                    let currentIndex = 0;
                    setInterval(() => {
                        images[currentIndex].classList.remove('opacity-100');
                        images[currentIndex].classList.add('opacity-0');
                        currentIndex = (currentIndex + 1) % images.length;
                        images[currentIndex].classList.remove('opacity-0');
                        images[currentIndex].classList.add('opacity-100');
                    }, 5000);
                }

                // Scroll animation logic for individual cards
                const scrollObserver = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            scrollObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                document.querySelectorAll('.reveal-card').forEach(el => {
                    scrollObserver.observe(el);
                });

                // Filter logic (for the featured cars section)
                const filterButtons = document.querySelectorAll('.filter-btn');
                const carCards = document.querySelectorAll('.car-card');

                filterButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        filterButtons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                        const filter = this.getAttribute('data-filter');

                        carCards.forEach(card => {
                            if (filter === 'all' || card.getAttribute('data-type') === filter) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });
            });
        </script>
    </x-slot>

</x-layout>