<x-layout title="Privacy Policy - Car Rent" bodyClass="bg-white">

    <!-- Main Content -->
    <main>
        <!-- Page Header -->
        <section class="bg-white py-20 lg:py-28 border-b border-gray-200">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                    Privacy Policy
                </h1>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.
                </p>
                <p class="mt-2 text-sm text-gray-500">Last Updated: October 19, 2025</p>
            </div>
        </section>

        <!-- Policy Content -->
        <section class="py-24 lg:py-32">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl space-y-12">

                <!-- Section: Information We Collect -->
                <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-user-group class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0"/>
                        <h2 class="text-2xl font-bold text-gray-900">Information We Collect</h2>
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <p>To provide our services, we collect information that you voluntarily provide to us during the booking process. This includes:</p>
                        <ul class="list-disc list-inside ml-4 space-y-2">
                            <li><strong>Personal Identification:</strong> Your full name, email address, and phone number.</li>
                            <li><strong>Booking Details:</strong> The specific vehicle you've chosen, rental dates, and any selected extras such as insurance or a personal driver.</li>
                            <li><strong>Usage Data:</strong> We may collect non-personal information about how you interact with our website to help us improve our user experience.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section: How We Use Your Information -->
                <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-cog-6-tooth class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0"/>
                        <h2 class="text-2xl font-bold text-gray-900">How We Use Your Information</h2>
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <p>Your information is used exclusively to facilitate your car rental experience. This includes:</p>
                         <ul class="list-disc list-inside ml-4 space-y-2">
                            <li>To process, confirm, and manage your vehicle booking.</li>
                            <li>To communicate important updates regarding your rental, such as pickup details or confirmations.</li>
                            <li>To provide customer support and respond to your inquiries.</li>
                            <li>To ensure the security of your booking and prevent fraudulent activities.</li>
                        </ul>
                    </div>
                </div>

                <!-- Section: Data Security -->
                <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-lock-closed class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0"/>
                        <h2 class="text-2xl font-bold text-gray-900">Data Security</h2>
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <p>We are committed to protecting your information. We implement a variety of security measures to maintain the safety of your personal data when you place a booking. All payment transactions are processed through secure gateway providers and are not stored or processed on our servers.</p>
                    </div>
                </div>

                <!-- Section: Information Sharing -->
                <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-building-office-2 class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0"/>
                        <h2 class="text-2xl font-bold text-gray-900">Third-Party Disclosure</h2>
                    </div>
                     <div class="space-y-4 text-gray-700">
                        <p>We do not sell, trade, or otherwise transfer your personally identifiable information to outside parties. This does not include trusted third parties who assist us in operating our website or servicing you (such as payment gateways), so long as those parties agree to keep this information confidential. We may also release information when its release is appropriate to comply with the law or protect ours or others' rights, property, or safety.</p>
                    </div>
                </div>

                <!-- Section: Cookies -->
                <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-cpu-chip class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0"/>
                        <h2 class="text-2xl font-bold text-gray-900">Use of Cookies</h2>
                    </div>
                    <div class="space-y-4 text-gray-700">
                        <p>Our website may use "cookies" to enhance user experience. Cookies are small files that a site transfers to your computer's hard drive through your Web browser (if you allow) that enables the site's systems to recognize your browser and capture and remember certain information. We use them to understand and save your preferences for future visits. You can choose to disable cookies through your individual browser options.</p>
                    </div>
                </div>

                <!-- Section: Contact -->
                 <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-envelope class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0"/>
                        <h2 class="text-2xl font-bold text-gray-900">Contact Us</h2>
                    </div>
                    <p class="text-gray-700">If you have any questions regarding this privacy policy, you may <a href="{{ route('contact') }}" class="text-blue-600 hover:underline font-medium">contact us</a> using the information on our contact page.</p>
                    <p class="mt-4 text-sm text-gray-500 italic">This document is for portfolio purposes and is not a legally binding Privacy Policy.</p>
                 </div>

            </div>
        </section>
    </main>

</x-layout>