<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col sm:flex-row sm:items-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year</label>
                        <select name="year" id="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Month (Optional)</label>
                        <select name="month" id="month" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Months</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Apply Filter
                    </button>
                     <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-2">
                        Reset
                    </a>
                </form>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Showing data for: {{ $selectedMonth ? \Carbon\Carbon::create()->month( (int)$selectedMonth )->format('F') . ', ' : '' }} {{ $selectedYear }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 flex items-center space-x-4">
                     <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                         <x-heroicon-o-currency-dollar class="h-6 w-6 text-white"/>
                     </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Revenue</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">Rp {{ number_format($totalRevenue) }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 flex items-center space-x-4">
                     <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                         <x-heroicon-o-bookmark class="h-6 w-6 text-white"/>
                     </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Confirmed Bookings</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalBookings }}</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6 flex items-center space-x-4">
                     <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                         <x-heroicon-o-truck class="h-6 w-6 text-white"/>
                     </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Cars</h3>
                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalCars }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                     <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">Revenue Overview ({{ $selectedYear }})</h3>

                     <div class="relative h-96">
                        <canvas id="revenueChart"></canvas>
                     </div>
                 </div>

                 <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                     <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">Bookings by Car Type</h3>

                     <div class="relative h-96 flex justify-center items-center">
                        <canvas id="carTypeChart"></canvas>
                     </div>
                 </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold leading-6">Most Rented Cars (Overall)</h3>
                    </div>
                    <div class="p-6">
                        @if($mostRentedCars->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400">No booking data available yet.</p>
                        @else
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($mostRentedCars as $car)
                                    <li class="py-3 flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $car->brand }} {{ $car->model }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $car->booking_count }} bookings</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700">
                         <h3 class="text-lg font-semibold leading-6">Recent Bookings (Latest 5)</h3>
                    </div>
                    <div class="p-6">
                         @if($recentBookings->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400">No recent bookings found.</p>
                        @else
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentBookings as $booking)
                                    <li class="py-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $booking->car->brand ?? 'N/A' }} {{ $booking->car->model ?? 'N/A' }}
                                            <span class="text-xs text-gray-500">by {{ $booking->user->name ?? 'N/A' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }} | Rp {{ number_format($booking->total_price) }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                         @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

   @push('scripts')
    {{-- Ensure Chart.js is loaded in layouts/app.blade.php before @stack('scripts') --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data from controller
            const revenueData = @json($revenueChartData);
            const carTypeData = @json($bookingsByType);

            // --- Determine Colors based on Dark Mode ---
            const isDarkMode = localStorage.getItem('color-theme') === 'dark' ||
                             (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            const gridColor = isDarkMode ? 'rgba(107, 114, 128, 0.3)' : 'rgba(209, 213, 219, 0.5)'; // gray-500/30 vs gray-300/50
            const tickColor = isDarkMode ? 'rgb(156, 163, 175)' : 'rgb(107, 114, 128)'; // gray-400 vs gray-500
            const labelColor = isDarkMode ? 'rgb(209, 213, 219)' : 'rgb(55, 65, 81)';   // gray-300 vs gray-600

            // --- Calculate Max Revenue (Only needed if explicitly setting max) ---
            // let maxRevenue = Math.max(...revenueData, 0);
            // let yAxisMax = 50000;
            // if (maxRevenue > 0) {
            //      yAxisMax = Math.ceil((maxRevenue * 1.1) / 100000) * 100000;
            // }

            // 1. Revenue Chart (Line Chart)
            const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [{
                            label: 'Revenue (Rp)',
                            data: revenueData,
                            borderColor: 'rgb(59, 130, 246)', // Blue-500
                            backgroundColor: 'rgba(59, 130, 246, 0.1)', // Light blue fill
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: isDarkMode ? 'rgb(17, 24, 39)' : '#fff', // gray-900 vs white
                            pointHoverBackgroundColor: isDarkMode ? 'rgb(17, 24, 39)' : '#fff',
                            pointHoverBorderColor: 'rgb(59, 130, 246)',
                            tension: 0.1,
                            fill: true // Fill area under the line
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                type: 'linear',
                                beginAtZero: true,
                                // max: yAxisMax, // Explicit max removed to use maxTicksLimit approach
                                grid: {
                                    color: gridColor // Set grid line color
                                },
                                ticks: {
                                    color: tickColor, // Set tick label color
                                    // Keep the improved number formatting
                                    callback: function(value, index, values) {
                                        if (value >= 1000000000) return 'Rp ' + (value / 1000000000) + 'B';
                                        if (value >= 1000000) {
                                            const millions = value / 1000000;
                                            return 'Rp ' + (millions % 1 === 0 ? millions : millions.toFixed(1)) + 'M';
                                        }
                                        if (value >= 1000) return 'Rp ' + (value / 1000) + 'k';
                                        return 'Rp ' + value;
                                    },
                                    maxTicksLimit: 10 // Control tick density
                                }
                            },
                             x: { // Added X-axis styling
                                grid: {
                                    display: false // Hide vertical grid lines
                                },
                                ticks: {
                                    color: tickColor // Set x-axis tick label color
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: labelColor // Set legend label color
                                }
                            },
                            tooltip: {
                                 backgroundColor: isDarkMode ? 'rgb(31, 41, 55)' : 'rgb(255, 255, 255)', // gray-800 vs white
                                 titleColor: isDarkMode ? 'rgb(209, 213, 219)' : 'rgb(55, 65, 81)',      // gray-300 vs gray-600
                                 bodyColor: isDarkMode ? 'rgb(209, 213, 219)' : 'rgb(55, 65, 81)',       // gray-300 vs gray-600
                                 borderColor: isDarkMode ? 'rgb(55, 65, 81)' : 'rgb(229, 231, 235)',      // gray-600 vs gray-200
                                 borderWidth: 1,
                                 callbacks: {
                                     label: function(context) {
                                         let label = context.dataset.label || '';
                                         if (label) label += ': ';
                                         if (context.parsed.y !== null) {
                                             label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                         }
                                         return label;
                                     }
                                 }
                            }
                        }
                    }
                });
             } else {
                 console.error("Revenue chart canvas not found");
             }


            // 2. Car Type Bookings Chart (Pie Chart)
            const carTypeCtx = document.getElementById('carTypeChart')?.getContext('2d');
            if (carTypeCtx && Object.keys(carTypeData).length > 0) {
                const carTypeLabels = Object.keys(carTypeData).map(type => type.charAt(0).toUpperCase() + type.slice(1));
                const carTypeCounts = Object.values(carTypeData);

                new Chart(carTypeCtx, {
                    type: 'pie',
                    data: {
                        labels: carTypeLabels,
                        datasets: [{
                            label: 'Bookings',
                            data: carTypeCounts,
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.7)',  // Blue
                                'rgba(16, 185, 129, 0.7)',  // Emerald
                                'rgba(239, 68, 68, 0.7)',   // Red
                                'rgba(245, 158, 11, 0.7)',  // Amber
                                'rgba(139, 92, 246, 0.7)',  // Violet
                                'rgba(96, 165, 250, 0.7)'   // Light Blue
                             ],
                            borderColor: isDarkMode ? 'rgb(31, 41, 55)' : '#fff', // gray-800 vs white
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: labelColor // Set legend label color
                                }
                            },
                            tooltip: {
                                 backgroundColor: isDarkMode ? 'rgb(31, 41, 55)' : 'rgb(255, 255, 255)',
                                 titleColor: isDarkMode ? 'rgb(209, 213, 219)' : 'rgb(55, 65, 81)',
                                 bodyColor: isDarkMode ? 'rgb(209, 213, 219)' : 'rgb(55, 65, 81)',
                                 borderColor: isDarkMode ? 'rgb(55, 65, 81)' : 'rgb(229, 231, 235)',
                                 borderWidth: 1,
                                 callbacks: {
                                     label: function(context) {
                                         let label = context.label || '';
                                         if (label) {
                                             label += ': ';
                                         }
                                         if (context.parsed !== null) {
                                             label += context.parsed + ' bookings';
                                         }
                                         return label;
                                     }
                                 }
                            }
                        }
                    }
                });
             } else if (carTypeCtx) {
                 carTypeCtx.font = "16px sans-serif";
                 carTypeCtx.fillStyle = tickColor; // Use tick color for message
                 carTypeCtx.textAlign = "center";
                 carTypeCtx.fillText("No booking data for this period", carTypeCtx.canvas.width / 2, carTypeCtx.canvas.height / 2);
            } else {
                 console.error("Car type chart canvas not found");
             }

        });
    </script>
    @endpush

</x-app-layout>