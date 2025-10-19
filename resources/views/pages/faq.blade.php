<x-layout title="Frequently Asked Questions - Car Rent">

    <x-slot name="head">
        <style>
            details > summary {
                list-style: none; /* Remove default marker */
            }
            details > summary::-webkit-details-marker {
                display: none; /* Remove default marker (Chrome) */
            }
            details > summary::after {
                content: '+'; /* Add plus sign */
                float: right;
                font-size: 1.5rem;
                font-weight: bold;
                transition: transform 0.2s ease-in-out;
            }
            details[open] > summary::after {
                content: '−'; /* Change to minus sign when open */
                transform: rotate(180deg);
            }
            /* Add some spacing */
            details:not(:last-child) {
                margin-bottom: 1rem;
            }
        </style>
    </x-slot>

    <main>
        <section class="bg-white py-20 lg:py-28 border-b border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                    Frequently Asked Questions
                </h1>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Have questions? We've got answers. Find information about payments, rentals, and more.
                </p>
            </div>
        </section>

        <section class="py-24 lg:py-32">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
                <div class="space-y-6">

                    <details class="bg-white p-6 rounded-lg shadow-md border border-gray-200 cursor-pointer">
                        <summary class="text-xl font-semibold text-gray-900 focus:outline-none">
                            What payment methods do you accept?
                        </summary>
                        <div class="mt-4 text-gray-700 space-y-2">
                            <p>We accept a variety of payment methods convenient for our customers in Indonesia:</p>
                            <ul class="list-disc list-inside ml-4">
                                <li><strong>Credit/Debit Cards:</strong> Visa, Mastercard.</li>
                                <li><strong>E-Wallets:</strong> GoPay, OVO, Dana.</li>
                                <li><strong>Bank Transfer:</strong> Virtual Account transfers from major Indonesian banks (BCA, Mandiri, BNI, etc.).</li>
                            </ul>
                            <p>Payment is required upfront to confirm your booking.</p>
                        </div>
                    </details>

                    <details class="bg-white p-6 rounded-lg shadow-md border border-gray-200 cursor-pointer">
                        <summary class="text-xl font-semibold text-gray-900 focus:outline-none">
                            What are the requirements to rent a car?
                        </summary>
                        <div class="mt-4 text-gray-700 space-y-2">
                            <p>To rent a car for self-drive, you generally need:</p>
                            <ul class="list-disc list-inside ml-4">
                                <li>A valid Indonesian driver's license (SIM A) or an International Driving Permit.</li>
                                <li>A valid ID card (KTP or Passport).</li>
                                <li>To be at least 21 years old (may vary for certain high-value vehicles).</li>
                            </ul>
                            <p>If you opt for our driver service, you only need a valid ID.</p>
                        </div>
                    </details>

                    <details class="bg-white p-6 rounded-lg shadow-md border border-gray-200 cursor-pointer">
                        <summary class="text-xl font-semibold text-gray-900 focus:outline-none">
                            Can I add a driver to my rental?
                        </summary>
                        <div class="mt-4 text-gray-700 space-y-2">
                            <p>Absolutely! You can select the "Add a Driver" option during the booking process on our website. Our professional drivers are experienced and knowledgeable about local routes.</p>
                            <p>The additional fee for a driver is Rp 200.000 per day, covering their service during standard operational hours (typically 8-10 hours/day). Overtime fees may apply.</p>
                        </div>
                    </details>

                    <details class="bg-white p-6 rounded-lg shadow-md border border-gray-200 cursor-pointer">
                        <summary class="text-xl font-semibold text-gray-900 focus:outline-none">
                            What is your cancellation policy?
                        </summary>
                        <div class="mt-4 text-gray-700 space-y-2">
                            <p>We understand plans can change. Our cancellation policy is as follows:</p>
                            <ul class="list-disc list-inside ml-4">
                                <li><strong>Full Refund:</strong> Cancellations made more than 48 hours before the scheduled pickup time.</li>
                                <li><strong>Partial Refund (50%):</strong> Cancellations made between 24 and 48 hours before pickup.</li>
                                <li><strong>No Refund:</strong> Cancellations made less than 24 hours before pickup, or no-shows.</li>
                            </ul>
                            <p>Please contact our support team to process any cancellations.</p>
                        </div>
                    </details>

                     <details class="bg-white p-6 rounded-lg shadow-md border border-gray-200 cursor-pointer">
                        <summary class="text-xl font-semibold text-gray-900 focus:outline-none">
                            Is insurance included in the rental price?
                        </summary>
                        <div class="mt-4 text-gray-700 space-y-2">
                            <p>Basic third-party liability insurance is included in the rental price as required by law. We also offer optional Collision Damage Waiver (CDW) or comprehensive insurance packages for added peace of mind during your rental.</p>
                            <p>You can review and select insurance options during the booking process. Please note that deductibles (excess fees) may apply in case of damage, depending on the chosen insurance level.</p>
                        </div>
                    </details>

                    </div>

                <div class="mt-16 text-center text-gray-600">
                    <p>Can't find the answer you're looking for?</p>
                    <a href="{{ route('contact') }}" class="mt-2 inline-block font-semibold text-black hover:underline">
                        Contact our support team
                    </a>
                </div>
            </div>
        </section>
    </main>

</x-layout>