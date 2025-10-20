<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'Car Rent - Your Journey, Your Choice' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{ $head ?? '' }}
    </head>
    <body class="font-sans antialiased {{ $bodyClass ?? 'bg-white' }}">

        <div x-data="{ open: false }" class="sticky top-0 z-50 bg-white shadow-md">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <a href="{{ route('home') }}" class="font-extrabold text-2xl tracking-tight text-gray-900 flex-shrink-0">
                        Car Rent
                    </a>

                    {{-- Desktop Menu Links --}}
                    <div class="hidden md:flex items-center space-x-10 font-semibold">
                        <a href="{{ route('cars.index') }}" class="{{ request()->routeIs('cars.index') ? 'text-gray-900' : 'text-gray-500' }} hover:text-gray-900 transition-colors">All Cars</a>
                        <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'text-gray-900' : 'text-gray-500' }} hover:text-gray-900 transition-colors">Our Services</a>
                        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-gray-900' : 'text-gray-500' }} hover:text-gray-900 transition-colors">Contact Us</a>
                    </div>

                    {{-- Desktop Auth Links --}}
                    <div class="hidden md:flex items-center space-x-4 flex-shrink-0">
                         @auth
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="font-semibold text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Admin Dashboard</a>
                            @else
                                <a href="{{ route('booking.index') }}" class="font-semibold text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">My Bookings</a>
                                <a href="{{ route('profile.edit') }}" class="font-semibold text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">My Profile</a>
                            @endif
                            {{-- Logout Form --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="font-semibold text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out ml-4">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="font-semibold text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out">Register</a>
                            @endif
                        @endauth
                    </div>

                    {{-- Hamburger Button --}}
                    <div class="-mr-2 flex items-center md:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div> {{-- End flex justify-between --}}
            </div> {{-- End container --}}

            {{-- Mobile Menu --}}
            <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-gray-200">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('cars.index')" :active="request()->routeIs('cars.index')">
                        All Cars
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('services')" :active="request()->routeIs('services')">
                        Our Services
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        Contact Us
                    </x-responsive-nav-link>
                </div>

                {{-- Mobile Auth Links/User Info --}}
                <div class="pt-4 pb-3 border-t border-gray-200">
                    @auth
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            @if (Auth::user()->role === 'admin')
                                <x-responsive-nav-link :href="route('admin.dashboard')">
                                    Admin Dashboard
                                </x-responsive-nav-link>
                            @else
                                <x-responsive-nav-link :href="route('booking.index')">
                                    My Bookings
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('profile.edit')">
                                    My Profile
                                </x-responsive-nav-link>
                            @endif
                            {{-- Logout Form --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    @else
                        <div class="space-y-1">
                            <x-responsive-nav-link :href="route('login')">
                                Log in
                            </x-responsive-nav-link>
                            @if (Route::has('register'))
                                <x-responsive-nav-link :href="route('register')">
                                    Register
                                </x-responsive-nav-link>
                            @endif
                        </div>
                    @endauth
                </div>
            </div> {{-- End Mobile Menu --}}
        </div> {{-- End Sticky Header Div --}}

        {{-- Main Content Slot --}}
        {{ $slot }}

        <footer class="bg-gray-900 text-gray-300 border-t border-gray-700">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-12">

                    <div class="md:col-span-4 lg:col-span-2">
                        <a href="{{ route('home') }}" class="font-extrabold text-3xl tracking-tight text-white">
                            Car Rent
                        </a>
                        <p class="mt-4 text-gray-400 max-w-xs">Your Journey, Your Choice. Find the perfect vehicle for your next adventure.</p>
                    </div>

                    <div class="lg:col-span-1">
                        <h4 class="text-sm font-semibold tracking-wider text-gray-400 uppercase">Quick Links</h4>
                        <ul class="mt-4 space-y-3">
                            <li><a href="{{ route('cars.index') }}" class="hover:text-white transition-colors">All Cars</a></li>
                            <li><a href="{{ route('services') }}" class="hover:text-white transition-colors">Our Services</a></li>
                            <li><a href="{{ route('home') }}#how-it-works" class="hover:text-white transition-colors">How It Works</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                        </ul>
                    </div>

                    <div class="lg:col-span-1">
                        <h4 class="text-sm font-semibold tracking-wider text-gray-400 uppercase">Support</h4>
                        <ul class="mt-4 space-y-3">
                            <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact Us</a></li>
                            <li><a href="{{ route('faq') }}" class="hover:text-white transition-colors">FAQ</a></li>
                            <li><a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
                            <li><a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms of Service</a></li>
                        </ul>
                    </div>

                    <div class="lg:col-span-1">
                        <h4 class="text-sm font-semibold tracking-wider text-gray-400 uppercase">Contact Us</h4>
                        <ul class="mt-4 space-y-3">
                            <li class="flex items-start">
                                <x-heroicon-o-map-pin class="h-5 w-5 flex-shrink-0 text-gray-400 mt-0.5" />
                                <span class="ml-2">Gambir, Central Jakarta City, Jakarta 10110</span>
                            </li>
                            <li class="flex items-start">
                                <x-heroicon-o-phone class="h-5 w-5 flex-shrink-0 text-gray-400 mt-0.5" />
                                <span class="ml-2">+62 21 1234 5678</span>
                            </li>
                             <li class="flex items-start">
                                <x-heroicon-o-envelope class="h-5 w-5 flex-shrink-0 text-gray-400 mt-0.5" />
                                <span class="ml-2">support@carrent.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-16 pt-8 border-t border-gray-700 flex flex-col sm:flex-row justify-between items-center">
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Car Rent. All rights reserved.</p>

                    <div class="flex space-x-5 mt-4 sm:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2.1c-2.78 0-3.14.01-4.24.06-1.09.05-1.85.22-2.5.49-.66.27-1.22.64-1.79 1.21-.57.57-.94 1.13-1.21 1.79-.27.65-.44 1.41-.49 2.5-.05 1.1-.06 1.46-.06 4.24s.01 3.14.06 4.24c.05 1.09.22 1.85.49 2.5.27.66.64 1.22 1.21 1.79.57.57 1.13.94 1.79 1.21.65.27 1.41.44 2.5.49 1.1.05 1.46.06 4.24.06 2.78 0 3.14-.01 4.24-.06 1.09-.05 1.85-.22 2.5-.49.66-.27 1.22.64-1.79-1.21.57-.57.94-1.13 1.21-1.79.27-.65.44-1.41.49-2.5.05-1.1.06-1.46.06-4.24s-.01-3.14-.06-4.24c-.05-1.09-.22-1.85-.49-2.5-.27-.66-.64-1.22-1.21-1.79-.57-.57-1.13-.94-1.79-1.21-.65-.27-1.41-.44-2.5-.49-1.1-.05-1.46-.06-4.24-.06zM12 4.14c2.68 0 3.03.01 4.09.06 1.04.05 1.6.21 2.05.39.54.21 1 .48 1.45.93.45.45.72.9.93 1.45.18.45.34 1.01.39 2.05.05 1.06.06 1.41.06 4.09s-.01 3.03-.06 4.09c-.05 1.04-.21 1.6-.39 2.05-.21.54-.48 1-.93 1.45-.45-.45-.9.72-1.45.93-.45.18-1.01.34-2.05.39-1.06.05-1.41.06-4.09.06s-3.03-.01-4.09-.06c-1.04-.05-1.6-.21-2.05-.39-.54-.21-1-.48-1.45-.93-.45-.45-.72-.9-.93-1.45-.18-.45-.34-1.01-.39-2.05-.05-1.06-.06-1.41-.06-4.09s.01-3.03.06-4.09c.05-1.04.21 1.6.39 2.05.21-.54.48 1 .93-1.45.45-.45.9-.72 1.45-.93.45-.18 1.01.34 2.05.39 1.06-.05 1.41-.06 4.09-.06zM12 9.27a2.73 2.73 0 100 5.46 2.73 2.73 0 000-5.46zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm4.42-7.6a.97.97 0 100-1.94.97.97 0 000 1.94z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        {{ $scripts ?? '' }}
    </body>
</html>