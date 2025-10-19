<x-layout title="Booking Confirmed! - Car Rent" bodyClass="bg-gray-50">

    <main class="py-16 lg:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-lg shadow-lg border border-gray-200 text-center">
                <div class="flex items-center justify-center h-16 w-16 mx-auto mb-6 bg-green-100 rounded-full border-4 border-white shadow-sm">
                    <x-heroicon-o-check-circle class="h-10 w-10 text-green-600" />
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                    Booking Confirmed!
                </h1>

                @if(session('success'))
                    <p class="mt-4 text-lg text-gray-600">{{ session('success') }}</p>
                @endif

                <div class="mt-8 text-left border-t border-gray-200 pt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Reservation Details</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Vehicle:</span>
                            <span class="font-medium text-gray-900">{{ $booking->car->brand }} {{ $booking->car->model }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Rental Period:</span>
                            <span class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }} -
                                {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                            </span>
                        </div>
                         <div class="flex justify-between text-xl font-bold text-gray-900 border-t border-gray-200 pt-3">
                            <span>Total Price:</span>
                            <span>Rp {{ number_format($booking->total_price) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors mr-6">
                        Back to Home
                    </a>
                    <a href="{{ route('booking.index') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors">
                        View My Bookings
                    </a>
                </div>

            </div>

        </div>
    </main>

</x-layout>