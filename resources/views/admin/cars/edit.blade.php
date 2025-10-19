<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Car: {{ $car->brand }} {{ $car->model }}
            </h2>
            {{-- Back Button --}}
            <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="mb-6 px-4 py-3 leading-normal text-green-700 bg-green-100 dark:bg-green-900/50 dark:text-green-300 border border-green-200 dark:border-green-800 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif
             @if (session('error'))
                 <div class="mb-6 px-4 py-3 leading-normal text-red-700 bg-red-100 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-lg" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-lg">
                    <strong class="font-bold">Please fix the following errors:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                {{-- Main form wraps all editable fields --}}
                <form id="update-car-form" method="POST" action="{{ route('admin.cars.update', $car) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Main form uses PUT --}}

                    <div class="px-6 py-8 md:px-8 md:py-10 space-y-10">

                        <div class="space-y-6">
                             <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Basic Information</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update the make and model.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="brand" :value="__('Brand')" />
                                    <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand', $car->brand)" required autofocus />
                                    <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="model" :value="__('Model')" />
                                    <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model', $car->model)" required />
                                    <x-input-error :messages="$errors->get('model')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                             <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Specifications</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update the car's features.</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="body_type" :value="__('Body Type')" />
                                    <select id="body_type" name="body_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="sedan" {{ old('body_type', $car->body_type) == 'sedan' ? 'selected' : '' }}>Sedan</option>
                                        <option value="suv" {{ old('body_type', $car->body_type) == 'suv' ? 'selected' : '' }}>SUV</option>
                                        <option value="mpv" {{ old('body_type', $car->body_type) == 'mpv' ? 'selected' : '' }}>MPV</option>
                                        <option value="hatchback" {{ old('body_type', $car->body_type) == 'hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('body_type')" class="mt-2" />
                                </div>
                                <div>
                                     <x-input-label for="transmission" :value="__('Transmission')" />
                                    <select id="transmission" name="transmission" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('transmission')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="seats" :value="__('Seats')" />
                                    <x-text-input id="seats" class="block mt-1 w-full" type="number" name="seats" :value="old('seats', $car->seats)" required min="1" step="1"/>
                                    <x-input-error :messages="$errors->get('seats')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="fuel_type" :value="__('Fuel Type')" />
                                    <select id="fuel_type" name="fuel_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="gasoline" {{ old('fuel_type', $car->fuel_type) == 'gasoline' ? 'selected' : '' }}>Gasoline</option>
                                        <option value="diesel" {{ old('fuel_type', $car->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('fuel_type', $car->fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="hybrid" {{ old('fuel_type', $car->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="year" :value="__('Year')" />
                                    <x-text-input id="year" class="block mt-1 w-full" type="number" name="year" :value="old('year', $car->year)" required min="1990" max="{{ date('Y') + 1 }}" step="1" />
                                    <x-input-error :messages="$errors->get('year')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Administrative & Pricing</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update the car's identifier and rental cost.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="license_plate" :value="__('License Plate')" />
                                    <x-text-input id="license_plate" class="block mt-1 w-full uppercase" type="text" name="license_plate" :value="old('license_plate', $car->license_plate)" required />
                                    <x-input-error :messages="$errors->get('license_plate')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="price_per_day" :value="__('Price per Day (IDR)')" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                          <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <x-text-input id="price_per_day" class="block w-full pl-8" type="number" step="1000" min="0" name="price_per_day" :value="old('price_per_day', $car->price_per_day)" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('price_per_day')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                         <div class="space-y-6">
                             <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Images</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage car photos. Select one as the main thumbnail.</p>
                            </div>
                            <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-4">
                                @forelse ($car->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Car Image {{ $loop->iteration }}" class="rounded-lg object-cover w-full aspect-square border border-gray-200 dark:border-gray-700">
                                        {{-- Thumbnail Selector --}}
                                        <div class="absolute bottom-0 left-0 right-0 p-1 bg-gradient-to-t from-black/60 to-transparent rounded-b-lg">
                                            <label class="flex items-center justify-center space-x-1 cursor-pointer">
                                                <input type="radio" name="thumbnail_id" value="{{ $image->id }}" {{ $image->is_thumbnail ? 'checked' : '' }} class="form-radio h-3.5 w-3.5 text-indigo-600 bg-gray-700 border-gray-500 focus:ring-indigo-500">
                                                <span class="text-xs text-white font-medium">Main</span>
                                            </label>
                                        </div>
                                        {{-- Delete Button --}}
                                        <div class="absolute -top-2 -right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" class="delete-image-btn p-1 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-md" data-action="{{ route('admin.cars.images.destroy', $image) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400 col-span-full text-center py-4">This car has no images yet.</p>
                                @endforelse
                             </div>
                            <div class="mt-6">
                                <label for="images" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Add New Images</label>
                                <input id="images" class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-lg file:border-0
                                                        file:text-sm file:font-semibold
                                                        file:bg-indigo-50 file:text-indigo-700
                                                        hover:file:bg-indigo-100"
                                       type="file" name="images[]" multiple accept="image/png, image/jpeg, image/jpg">
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG (MAX. 2MB each). Select multiple files.</p>
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                            </div>
                        </div>

                    </div> <div class="flex items-center justify-end gap-x-6 px-6 py-4 md:px-8 md:py-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 rounded-b-lg">
                        <a href="{{ route('admin.cars.index') }}" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100">Cancel</a>
                        <x-primary-button>
                            {{ __('Update Car') }}
                        </x-primary-button>
                    </div>
                </form> {{-- End Main Form --}}
            </div> <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-5 md:px-8 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100">Car Status</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage the availability of this vehicle.</p>
                </div>
                <div class="px-6 py-8 md:px-8 md:py-10 space-y-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Current Status:</span>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                            @switch($car->status)
                                @case('available') bg-green-100 text-green-800 dark:bg-green-900/80 dark:text-green-300 @break
                                @case('maintenance') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/80 dark:text-yellow-300 @break
                                @case('archived') bg-gray-100 text-gray-800 dark:bg-gray-700/80 dark:text-gray-300 @break
                                @default bg-red-100 text-red-800 dark:bg-red-900/80 dark:text-red-300
                            @endswitch
                        ">
                            {{ ucfirst($car->status) }}
                        </span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-4 items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        @if($car->status !== 'available')
                            <form action="{{ route('admin.cars.status.available', $car) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                                     <x-heroicon-o-check-circle class="h-4 w-4 mr-2"/> Set Available
                                </button>
                            </form>
                        @endif
                        @if($car->status !== 'maintenance')
                            <form action="{{ route('admin.cars.status.maintenance', $car) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                                    <x-heroicon-o-wrench-screwdriver class="h-4 w-4 mr-2"/> Set Maintenance
                                </button>
                            </form>
                        @endif
                        @if($car->status !== 'archived')
                            <form action="{{ route('admin.cars.status.archived', $car) }}" method="POST" class="inline" onsubmit="return confirm('Archiving hides the car but keeps booking history. Are you sure?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                                    <x-heroicon-o-archive-box-arrow-down class="h-4 w-4 mr-2"/> Archive Car
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div> </div>
    </div>

    <form id="delete-image-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-image-btn');
            const deleteForm = document.getElementById('delete-image-form');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    if (confirm('Are you sure you want to delete this image?')) {
                        const action = this.getAttribute('data-action');
                        deleteForm.action = action;
                        deleteForm.submit();
                    }
                });
            });
        });
    </script>
    @endpush

</x-app-layout>