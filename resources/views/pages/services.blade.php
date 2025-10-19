<x-layout title="Our Services - Car Rent">

    <main>
        <section class="bg-white py-20 lg:py-28 border-b border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                    Premium Services, Tailored For You
                </h1>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    From seamless airport pickups to exclusive VIP escorts, we handle the details so you can enjoy the journey.
                </p>
            </div>
        </section>

        <section class="py-24 lg:py-32 space-y-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <div>
                        <img src="{{ asset('images/services/delivery.jpg') }}" alt="Airport Pickup Service" class="w-full h-80 object-cover rounded-lg shadow-xl">
                    </div>
                    <div>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Convenience</span>
                        <h2 class="mt-4 text-3xl font-bold text-gray-900">Seamless Pickup & Delivery</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            Start your journey the moment you arrive. We provide timely and professional pickup services from any major point in the city.
                        </p>
                        <ul class="mt-6 space-y-3">
                            <li class="flex items-center text-gray-700">
                                <x-heroicon-o-check-circle class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" />
                                <span><strong>Airport:</strong> We'll meet you at the terminal.</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <x-heroicon-o-check-circle class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" />
                                <span><strong>Hotel:</strong> Your car delivered to your lobby.</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <x-heroicon-o-check-circle class="h-6 w-6 text-blue-600 mr-3 flex-shrink-0" />
                                <span><strong>Train Station:</strong> A hassle-free connection.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <div class="lg:order-last">
                        <img src="{{ asset('images/services/driver.jpg') }}" alt="Professional Driver Service" class="w-full h-80 object-cover rounded-lg shadow-xl">
                    </div>
                    <div>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Comfort & Safety</span>
                        <h2 class="mt-4 text-3xl font-bold text-gray-900">Professional Driver Service</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            Sit back, relax, and let our experienced chauffeurs navigate the city for you. Whether for business or leisure, our drivers are vetted, professional, and have expert local knowledge to ensure you arrive at your destination safely and on time.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <div>
                        <img src="{{ asset('images/services/vip.jpg') }}" alt="VIP Police Escort" class="w-full h-80 object-cover rounded-lg shadow-xl">
                    </div>
                    <div>
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Exclusive</span>
                        <h2 class="mt-4 text-3xl font-bold text-gray-900">Exclusive VIP Treatment</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            For those who require an unparalleled level of service, our VIP package provides the ultimate in luxury, security, and convenience. This service includes priority vehicle preparation and discreet police escorts to ensure your travel is seamless and secure.
                        </p>
                        <p class="mt-4 text-md text-gray-500">
                            *Due to the nature of this service, VIP packages must be arranged in advance.
                        </p>
                        <a href="{{ route('contact') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors mt-6">
                            Contact Us for Details
                        </a>
                    </div>
                </div>

            </div>
        </section>
    </main>

</x-layout>