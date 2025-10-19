<x-layout title="Contact Us - Car Rent">

    <main class="bg-white py-24 lg:py-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-3xl mx-auto text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                    Get In Touch
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    We're here to help. Whether you have a question about our fleet, services, or a booking, our team is ready to answer.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

                <div class="bg-gray-50 p-8 rounded-lg border border-gray-200">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
                    
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" autocomplete="name"
                                       class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                                       placeholder="Your Name">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email Address</label>
                            <div class="mt-2">
                                <input type="email" name="email" id="email" autocomplete="email"
                                       class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                                       placeholder="you@example.com">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium leading-6 text-gray-900">Subject</label>
                            <div class="mt-2">
                                <input type="text" name="subject" id="subject"
                                       class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                                       placeholder="e.g. Question about VIP Service">
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium leading-6 text-gray-900">Message</label>
                            <div class="mt-2">
                                <textarea name="message" id="message" rows="4"
                                          class="block w-full rounded-md border-0 py-2.5 px-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6"
                                          placeholder="Your message..."></textarea>
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                    class="w-full bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <div class="space-y-12">
                    <div class="bg-gray-50 p-8 rounded-lg border border-gray-200">
                         <h3 class="text-3xl font-bold text-gray-900 mb-6">Visit Our Office</h3>
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

                    <div class="h-96 rounded-lg overflow-hidden shadow-xl border border-gray-200">
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
                </div>

            </div>
        </div>
    </main>

</x-layout>