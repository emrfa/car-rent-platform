<x-app-layout>
    <x-slot name="header">
         <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
            </h2>
             <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
             @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-lg">
                    <strong class="font-bold">Please fix the following errors:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-8 md:px-8 md:py-10 space-y-8">

                        <div class="space-y-4">
                             <div class="border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Booking Details</h3>
                             </div>
                             <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                                <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">User</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $booking->user->name ?? 'N/A' }} ({{ $booking->user->email ?? 'N/A' }})</dd>
                                </div>
                                 <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Car</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $booking->car->brand ?? 'N/A' }} {{ $booking->car->model ?? '' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Start Date</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">End Date</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</dd>
                                </div>
                                 <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Total Price</dt>
                                    <dd class="mt-1 font-semibold text-gray-900 dark:text-gray-100">Rp {{ number_format($booking->total_price) }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Insurance</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100 capitalize">{{ $booking->insurance_type ?? 'None' }} (Rp {{ number_format($booking->insurance_cost) }})</dd>
                                </div>
                                {{-- Add Driver Cost if you store it --}}
                                {{-- <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Driver Included</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $booking->driver_cost > 0 ? 'Yes' : 'No' }}</dd>
                                </div> --}}
                             </dl>
                        </div>

                        <div class="space-y-4 pt-8 border-t border-gray-200 dark:border-gray-700">
                             <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Update Status</h3>
                            <div>
                                <x-input-label for="status" :value="__('Booking Status')" />
                                <select id="status" name="status" class="mt-1 block w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ old('status', $booking->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Change the status (e.g., confirm a pending booking, mark as completed, or cancel).
                            </p>
                        </div>

                        {{-- Optional: Add fields to edit dates here if needed, with necessary warnings/validation --}}

                    </div> <div class="flex items-center justify-end gap-x-6 px-6 py-4 md:px-8 md:py-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 rounded-b-lg">
                        <a href="{{ route('admin.bookings.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">Cancel</a>
                        <x-primary-button>
                            {{ __('Update Booking') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>