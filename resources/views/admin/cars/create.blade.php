<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Car') }}
            </h2>
            {{-- Back Button Added Here --}}
            <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <x-heroicon-o-arrow-left class="h-4 w-4 mr-1.5"/>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-8 md:px-8 md:py-10 space-y-10"> {{-- Increased overall padding and spacing --}}

                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Basic Information</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Enter the make and model of the vehicle.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="brand" :value="__('Brand')" />
                                    <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand')" required autofocus placeholder="e.g., Toyota" />
                                    <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="model" :value="__('Model')" />
                                    <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model')" required placeholder="e.g., Avanza" />
                                    <x-input-error :messages="$errors->get('model')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Specifications</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Provide details about the car's features.</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="body_type" :value="__('Body Type')" />
                                    <select id="body_type" name="body_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="sedan" {{ old('body_type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                        <option value="suv" {{ old('body_type') == 'suv' ? 'selected' : '' }}>SUV</option>
                                        <option value="mpv" {{ old('body_type') == 'mpv' ? 'selected' : '' }}>MPV</option>
                                        <option value="hatchback" {{ old('body_type') == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('body_type')" class="mt-2" />
                                </div>
                                 <div>
                                     <x-input-label for="transmission" :value="__('Transmission')" />
                                    <select id="transmission" name="transmission" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="manual" {{ old('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automatic" {{ old('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('transmission')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="seats" :value="__('Seats')" />
                                    <x-text-input id="seats" class="block mt-1 w-full" type="number" name="seats" :value="old('seats')" required placeholder="e.g., 5" min="1" step="1"/>
                                    <x-input-error :messages="$errors->get('seats')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="fuel_type" :value="__('Fuel Type')" />
                                    <select id="fuel_type" name="fuel_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="gasoline" {{ old('fuel_type') == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                        <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="hybrid" {{ old('fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="year" :value="__('Year')" />
                                    <x-text-input id="year" class="block mt-1 w-full" type="number" name="year" :value="old('year')" required placeholder="e.g., 2023" min="1990" max="{{ date('Y') + 1 }}" step="1" />
                                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Administrative & Pricing</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Set the car's identifier and rental cost.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="license_plate" :value="__('License Plate')" />
                                    <x-text-input id="license_plate" class="block mt-1 w-full uppercase" type="text" name="license_plate" :value="old('license_plate')" required placeholder="e.g., B 1234 ABC" />
                                    <x-input-error :messages="$errors->get('license_plate')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="price_per_day" :value="__('Price per Day (IDR)')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                          <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <x-text-input id="price_per_day" class="block w-full pl-8" type="number" step="1000" min="0" name="price_per_day" :value="old('price_per_day')" required placeholder="e.g., 500000" />
                                    </div>
                                    <x-input-error :messages="$errors->get('price_per_day')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                             <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Images</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Upload multiple images. The first image will be the thumbnail.</p>
                            </div>
                            <div>
                                <label for="images" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Car Images</label>
                                <input id="images" class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-lg file:border-0
                                                        file:text-sm file:font-semibold
                                                        file:bg-indigo-50 file:text-indigo-700
                                                        hover:file:bg-indigo-100"
                                       type="file" name="images[]" multiple accept="image/png, image/jpeg, image/jpg">
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400" id="file_input_help">PNG, JPG, JPEG (MAX. 2MB each). Select multiple files.</p>
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" /> {{-- Show errors for individual files if needed --}}
                            </div>
                        </div>

                    </div> <div class="flex items-center justify-end gap-x-6 px-6 py-4 md:px-8 md:py-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 rounded-b-lg">
                        <a href="{{ route('admin.cars.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">Cancel</a>
                        <x-primary-button>
                            {{ __('Add Car') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>