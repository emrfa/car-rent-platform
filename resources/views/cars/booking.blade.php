@dump($errors->all())
<x-layout :title="'Book ' . $car->brand . ' ' . $car->model . ' - Car Rent'" bodyClass="bg-gray-50">

    <x-slot name="head">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            /* Flatpickr styles */
            .flatpickr-calendar { box-shadow: none; width: 100%; border: 1px solid #e5e7eb; border-radius: 0.5rem; }
            .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange { background: #111827; border-color: #111827; }
            .flatpickr-day.disabled { color: #d1d5db; text-decoration: line-through; }
            .flatpickr-day:hover { background: #f3f4f6; }
            /* Style for selected insurance */
            input[type="radio"]:checked + label { border-color: #111827; box-shadow: 0 0 0 2px rgba(17, 24, 39, 0.2); }
        </style>
    </x-slot>

    <main class="py-16 lg:py-24">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center md:relative md:text-center space-y-4 md:space-y-0 mb-8 md:mb-0">
                <div class="w-full md:absolute md:left-0 md:top-1/2 md:-translate-y-1/2 md:w-auto text-center md:text-left">
                    <a href="{{ route('cars.show', $car) }}"
                    class="inline-flex items-center px-5 py-2 bg-black text-white font-bold text-sm rounded-md hover:bg-gray-800 transition-colors duration-150 ease-in-out group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="inline h-4 w-4 mr-1.5 group-hover:-translate-x-0.5 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Go Back
                    </a>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight text-center w-full md:mx-auto">
                    Confirm Your Booking
                </h1>

            </div>
        </div>

            <div class="mt-12 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12">

                <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-lg border border-gray-200 h-fit">
                    {{-- Car Image, Title, Price, Specs --}}
                    <img class="w-full h-auto object-cover rounded-lg"
                         src="{{ asset('storage/' . ($car->thumbnail->path ?? ($car->images->first()->path ?? 'https://placehold.co/600x400/e2e8f0/2d3748?text=No+Image'))) }}"
                         alt="{{ $car->brand }} {{ $car->model }}">
                    <h2 class="mt-4 text-2xl font-bold text-gray-900">{{ $car->brand }} {{ $car->model }}</h2>
                    <p class="text-lg text-gray-700 font-semibold">
                        Rp {{ number_format($car->price_per_day) }}
                        <span class="text-sm font-normal text-gray-500">/ day</span>
                    </p>
                    <ul class="mt-4 space-y-2 text-gray-600 border-t border-gray-200 pt-4">
                        <li class="flex justify-between"><span>Body Type:</span> <span class="font-medium text-gray-900">{{ ucfirst($car->body_type) }}</span></li>
                        <li class="flex justify-between"><span>Transmission:</span> <span class="font-medium text-gray-900">{{ ucfirst($car->transmission) }}</span></li>
                        <li class="flex justify-between"><span>Seats:</span> <span class="font-medium text-gray-900">{{ $car->seats }}</span></li>
                        <li class="flex justify-between"><span>Fuel:</span> <span class="font-medium text-gray-900">{{ ucfirst($car->fuel_type) }}</span></li>
                        <li class="flex justify-between"><span>Year:</span> <span class="font-medium text-gray-900">{{ $car->year }}</span></li>
                    </ul>
                </div>

                <div class="lg:col-span-2 bg-white p-8 rounded-lg shadow-lg border border-gray-200">
                    <form id="booking-form" action="{{ route('booking.store', $car) }}" method="POST">
                        @csrf

                        <h3 class="text-xl font-bold text-gray-900 mb-2">1. Select Your Dates</h3>
                        <p class="text-gray-600 mb-4">Choose your rental start and end dates.</p>
                        <div id="booking-calendar" class="mb-6"></div>
                        <input type="hidden" name="start_date" id="start_date">
                        <input type="hidden" name="end_date" id="end_date">

                        <div class="border-t border-gray-200 pt-6 mt-6">
                           <h3 class="text-xl font-bold text-gray-900 mb-4">2. Choose Insurance</h3>
                            <fieldset class="space-y-4">
                                <legend class="sr-only">Insurance options</legend>
                                <div class="relative">
                                    <input id="insurance-none" name="insurance_type" type="radio" value="none" class="sr-only" checked>
                                    <label for="insurance-none" class="flex flex-col p-4 border border-gray-300 rounded-lg cursor-pointer transition-all hover:border-gray-400">
                                        <span class="font-medium text-gray-900">Basic Included Insurance</span>
                                        <span class="text-sm text-gray-600">Standard third-party liability coverage.</span>
                                        <span class="text-sm font-semibold text-gray-900 mt-1">+ Rp 0 / day</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input id="insurance-basic" name="insurance_type" type="radio" value="basic" class="sr-only">
                                    <label for="insurance-basic" class="flex flex-col p-4 border border-gray-300 rounded-lg cursor-pointer transition-all hover:border-gray-400">
                                        <span class="font-medium text-gray-900">Basic Protection (CDW)</span>
                                        <span class="text-sm text-gray-600">Reduces your financial liability for damage to the vehicle.</span>
                                        <span class="text-sm font-semibold text-gray-900 mt-1">+ Rp 50.000 / day</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input id="insurance-full" name="insurance_type" type="radio" value="full" class="sr-only">
                                    <label for="insurance-full" class="flex flex-col p-4 border border-gray-300 rounded-lg cursor-pointer transition-all hover:border-gray-400">
                                        <span class="font-medium text-gray-900">Full Protection</span>
                                        <span class="text-sm text-gray-600">Maximum coverage, minimizes liability for most damages.</span>
                                        <span class="text-sm font-semibold text-gray-900 mt-1">+ Rp 100.000 / day</span>
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">3. Add Extras</h3>
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input id="with_driver_checkbox" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-black focus:ring-black">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="with_driver_checkbox" class="font-medium text-gray-900">Add a Driver</label>
                                    <p class="text-gray-500">Professional driver for Rp 200.000/day.</p>
                                </div>
                            </div>
                            <input type="hidden" name="with_driver" id="with_driver" value="0">
                        </div>

                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">4. Booking Summary</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between text-gray-700">
                                    <span>Car rental (<span id="total-days">0</span> days)</span>
                                    <span id="car-subtotal" class="font-medium text-gray-900">Rp 0</span>
                                </div>
                                <div id="insurance-fee-summary" class="hidden flex justify-between text-gray-700">
                                    <span>Insurance fee</span>
                                    <span id="insurance-subtotal" class="font-medium text-gray-900">Rp 0</span>
                                </div>
                                <div id="driver-fee-summary" class="hidden flex justify-between text-gray-700">
                                    <span>Driver fee</span>
                                    <span id="driver-subtotal" class="font-medium text-gray-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-xl font-bold text-gray-900 border-t border-gray-200 pt-3">
                                    <span>Total Price</span>
                                    <span id="total-price">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6 mt-6">
                             <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input id="tos_agree" name="tos_agree" type="checkbox" required
                                           class="h-4 w-4 rounded border-gray-300 text-black focus:ring-black">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="tos_agree" class="text-gray-700">
                                        I have read and agree to the
                                        <a href="{{ route('terms') }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500 underline">Terms of Service</a>.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button id="confirm-booking-btn"
                                    type="submit"
                                    disabled
                                    class="w-full bg-black text-white font-bold py-3 px-8 rounded-md text-base transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed hover:bg-gray-800">
                                Confirm & Book
                            </button>
                            <p id="error-message" class="text-red-600 text-sm text-center mt-3"></p>
                             {{-- Display validation errors for tos_agree --}}
                             @error('tos_agree')
                                <p class="text-red-600 text-sm text-center mt-3">{{ $message }}</p>
                             @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // --- DATA & CONFIG ---
                const carPricePerDay = {{ $car->price_per_day }};
                const driverFeePerDay = 200000;
                const insuranceFees = { none: 0, basic: 50000, full: 100000 };
                const unavailableDates = @json($unavailableDates);

                // --- FORM ELEMENTS ---
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');
                const insuranceRadios = document.querySelectorAll('input[name="insurance_type"]');
                const driverCheckbox = document.getElementById('with_driver_checkbox');
                const driverHiddenInput = document.getElementById('with_driver');
                const tosCheckbox = document.getElementById('tos_agree'); // <-- Get the ToS checkbox
                const confirmBtn = document.getElementById('confirm-booking-btn');
                const errorElem = document.getElementById('error-message');

                // --- SUMMARY ELEMENTS ---
                const totalDaysElem = document.getElementById('total-days');
                const carSubtotalElem = document.getElementById('car-subtotal');
                const insuranceFeeSummaryElem = document.getElementById('insurance-fee-summary');
                const insuranceSubtotalElem = document.getElementById('insurance-subtotal');
                const driverFeeSummaryElem = document.getElementById('driver-fee-summary');
                const driverSubtotalElem = document.getElementById('driver-subtotal');
                const totalPriceElem = document.getElementById('total-price');

                // --- STATE ---
                let totalDays = 0;
                let isDateRangeValid = false;
                let selectedInsuranceType = 'none';

                // --- FORMATTER ---
                const numberFormatter = new Intl.NumberFormat('id-ID');

                // --- FUNCTIONS ---
                function updatePriceSummary() {
                    const isDriverChecked = driverCheckbox.checked;
                    const isTosChecked = tosCheckbox.checked; // <-- Check ToS state

                    if (!isDateRangeValid || totalDays <= 0) {
                        // Reset summary and disable button
                        totalDaysElem.textContent = '0';
                        carSubtotalElem.textContent = 'Rp 0';
                        insuranceFeeSummaryElem.classList.add('hidden');
                        driverFeeSummaryElem.classList.add('hidden');
                        totalPriceElem.textContent = 'Rp 0';
                        confirmBtn.disabled = true; // Always disable if dates invalid
                        driverHiddenInput.value = '0';
                        return;
                    }

                    // Calculate costs
                    const carSubtotal = totalDays * carPricePerDay;
                    const insuranceSubtotal = totalDays * insuranceFees[selectedInsuranceType];
                    const driverSubtotal = isDriverChecked ? totalDays * driverFeePerDay : 0;
                    const totalPrice = carSubtotal + insuranceSubtotal + driverSubtotal;

                    // Update summary UI
                    totalDaysElem.textContent = totalDays;
                    carSubtotalElem.textContent = `Rp ${numberFormatter.format(carSubtotal)}`;
                    totalPriceElem.textContent = `Rp ${numberFormatter.format(totalPrice)}`;

                    if (insuranceSubtotal > 0) {
                        insuranceSubtotalElem.textContent = `Rp ${numberFormatter.format(insuranceSubtotal)}`;
                        insuranceFeeSummaryElem.classList.remove('hidden');
                    } else { insuranceFeeSummaryElem.classList.add('hidden'); }

                    if (isDriverChecked) {
                        driverSubtotalElem.textContent = `Rp ${numberFormatter.format(driverSubtotal)}`;
                        driverFeeSummaryElem.classList.remove('hidden');
                        driverHiddenInput.value = '1';
                    } else {
                        driverFeeSummaryElem.classList.add('hidden');
                        driverHiddenInput.value = '0';
                    }

                    // Enable button ONLY if dates are valid AND ToS is checked
                    confirmBtn.disabled = !isTosChecked; // <-- Update button state based on ToS
                }

                // --- EVENT LISTENERS ---

                // 1. Insurance Radios
                insuranceRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        selectedInsuranceType = this.value;
                        updatePriceSummary();
                    });
                });

                // 2. Driver Checkbox
                driverCheckbox.addEventListener('change', updatePriceSummary);

                // 3. ToS Checkbox (NEW)
                tosCheckbox.addEventListener('change', updatePriceSummary); // Re-run checks when ToS changes

                // 4. Flatpickr Calendar
                const calendar = flatpickr("#booking-calendar", {
                    mode: "range",
                    inline: true,
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    disable: unavailableDates,
                    onChange: function(selectedDates, dateStr, instance) {
                        errorElem.textContent = '';
                        isDateRangeValid = false;
                        if (selectedDates.length === 2) {
                            const startDate = selectedDates[0];
                            const endDate = selectedDates[1];
                            isDateRangeValid = true;
                            for (const date of unavailableDates) {
                                const disabledDate = new Date(date);
                                const startOfDayDisabled = new Date(disabledDate.getFullYear(), disabledDate.getMonth(), disabledDate.getDate());
                                const startOfDayStart = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
                                const startOfDayEnd = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
                                if (startOfDayDisabled > startOfDayStart && startOfDayDisabled < startOfDayEnd) {
                                    isDateRangeValid = false; break;
                                }
                            }
                            if (isDateRangeValid) {
                                const diffTime = Math.abs(endDate - startDate);
                                totalDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                                startDateInput.value = startDate.toISOString().split('T')[0];
                                endDateInput.value = endDate.toISOString().split('T')[0];
                            } else {
                                totalDays = 0;
                                errorElem.textContent = 'Selected range includes unavailable dates.';
                                instance.clear();
                            }
                        } else { totalDays = 0; }
                        updatePriceSummary(); // Update summary after date change
                    }
                });
            });
        </script>
    </x-slot>

</x-layout>