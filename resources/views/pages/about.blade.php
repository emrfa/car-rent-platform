<x-layout title="About Us - Car Rent" bodyClass="bg-white">

    <main>
        <section class="bg-white py-20 lg:py-28 border-b border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                    Driving Your Journey Forward
                </h1>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Learn about Car Rent, our mission, and our commitment to providing exceptional car rental experiences in Jakarta.
                </p>
            </div>
        </section>

        <section class="py-24 lg:py-32">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl space-y-16">

                <div class="text-center">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-4">Our Mission</span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Redefining Car Rental</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        At Car Rent, our mission is simple: to provide a seamless, reliable, and premium car rental service that puts you in control of your journey. We believe renting a car should be easy, transparent, and enjoyable. From our meticulously maintained fleet to our dedicated customer support, we strive to exceed expectations at every turn.
                    </p>
                </div>

                <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-building-library class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0"/>
                        <h2 class="text-2xl font-bold text-gray-900">Our Story</h2>
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <p>Founded with a passion for both cars and customer service, Car Rent started as a small venture aiming to fill a gap in the Jakarta rental market. We saw a need for a provider that offered not just vehicles, but a complete, trustworthy travel solution. We focused on building a modern fleet, ensuring transparent pricing, and making the booking process as smooth as possible.</p>
                        <p>Today, while we've grown, our core principles remain the same. We are dedicated to continuous improvement, leveraging technology, and listening to our customers to provide the best possible rental experience in the city.</p>
                    </div>
                </div>

                 <div class="text-center">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-4">Our Values</span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">What Drives Us</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <x-heroicon-o-check-badge class="h-8 w-8 text-blue-600 mb-3"/>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality & Reliability</h3>
                            <p class="text-gray-600">Our fleet consists of modern, well-maintained vehicles to ensure your safety and comfort on the road.</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <x-heroicon-o-eye class="h-8 w-8 text-blue-600 mb-3"/>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Transparency</h3>
                            <p class="text-gray-600">We believe in fair, upfront pricing with no hidden fees. What you see is what you pay.</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <x-heroicon-o-chat-bubble-left-right class="h-8 w-8 text-blue-600 mb-3"/>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Customer Focus</h3>
                            <p class="text-gray-600">Your satisfaction is our priority. Our team is dedicated to providing friendly and helpful support.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center border-t border-gray-200 pt-16">
                     <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Start Your Journey?</h2>
                     <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                         Browse our wide selection of vehicles and find the perfect ride for your needs in Jakarta.
                     </p>
                     <a href="{{ route('cars.index') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors">
                         Explore Our Cars
                     </a>
                 </div>

            </div>
        </section>
    </main>

</x-layout>