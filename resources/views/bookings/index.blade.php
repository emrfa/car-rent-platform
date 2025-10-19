<x-layout title="My Bookings - Car Rent" bodyClass="bg-gray-50">

    <main class="py-16 lg:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <div class="max-w-4xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">
                        My Bookings
                    </h1>
                    {{-- Optional: Add a back button if desired --}}
                    {{-- <a href="{{ url()->previous(route('home')) }}" class="inline-flex items-center ...">Back</a> --}}
                </div>

                @if($bookings->isEmpty())
                    <div class="bg-white text-center p-12 rounded-lg shadow-md border border-gray-200">
                        <x-heroicon-o-inbox class="h-16 w-16 mx-auto text-gray-400 mb-4"/>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">No Bookings Yet</h3>
                        <p class="text-gray-600 mb-6">You haven't made any car reservations with us.</p>
                        <a href="{{ route('cars.index') }}" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-md text-base hover:bg-gray-800 transition-colors">
                            Find a Car to Rent
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($bookings as $booking)
                            <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200 flex flex-col md:flex-row">
                                <div class="md:w-1/3 flex-shrink-0">
                                    <a href="{{ route('cars.show', $booking->car) }}">
                                        <img class="h-48 w-full object-cover md:h-full md:rounded-l-lg md:rounded-r-none"
                                             src="{{ $booking->car?->thumbnail ? asset('storage/' . $booking->car->thumbnail->path) : ($booking->car?->images->first() ? asset('storage/' . $booking->car->images->first()->path) : 'https://placehold.co/600x400/e2e8f0/2d3748?text=No+Image') }}"
                                             alt="{{ $booking->car->brand ?? 'N/A' }} {{ $booking->car->model ?? 'N/A' }}">
                                     </a>
                                </div>
                                <div class="p-6 flex-grow">
                                    <div class="flex flex-col sm:flex-row justify-between sm:items-start mb-3">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 hover:text-indigo-700">
                                                <a href="{{ route('cars.show', $booking->car) }}">
                                                   {{ $booking->car->brand ?? 'Unknown Car' }} {{ $booking->car->model ?? '' }}
                                                </a>
                                            </h3>
                                             {{-- Status Badge - Can customize colors based on status --}}
                                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $booking->status === 'confirmed' ? 'green' : ($booking->status === 'completed' ? 'gray' : 'yellow') }}-100 text-{{ $booking->status === 'confirmed' ? 'green' : ($booking->status === 'completed' ? 'gray' : 'yellow') }}-800 capitalize">
                                                {{ $booking->status }}
                                            </span>
                                        </div>
                                        <div class="mt-2 sm:mt-0 text-left sm:text-right">
                                             <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($booking->total_price) }}</p>
                                             <p class="text-xs text-gray-500">Total Price</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 border-t border-gray-200 pt-4">
                                        <div>
                                            <p class="font-medium text-gray-800">Start Date:</p>
                                            <p>{{ \Carbon\Carbon::parse($booking->start_date)->format('D, M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">End Date:</p>
                                            <p>{{ \Carbon\Carbon::parse($booking->end_date)->format('D, M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">Insurance:</p>
                                            <p class="capitalize">{{ $booking->insurance_type ?? 'None' }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">Booking ID:</p>
                                            <p>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p> {{-- Example ID formatting --}}
                                        </div>
                                    </div>
                                     {{-- Optional: Add a link to view full booking details if needed --}}
                                     {{-- <div class="mt-4 text-right">
                                        <a href="{{ route('booking.show', $booking) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">View Details &rarr;</a>
                                     </div> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>

</x-layout>