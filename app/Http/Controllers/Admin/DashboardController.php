<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Make sure Carbon is imported

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // --- Filtering ---
        $currentYear = Carbon::now()->year;
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month');

        // --- Define statuses considered for revenue/counts ---
        $countedStatuses = ['confirmed', 'completed'];

        // --- Basic Stats ---
        $totalCars = Car::count();

        // Query builder for filtered bookings
        $bookingsQuery = Booking::whereIn('status', $countedStatuses)
                                ->whereYear('created_at', $selectedYear);
        if ($selectedMonth) {
            $bookingsQuery->whereMonth('created_at', $selectedMonth);
        }

        $filteredBookings = $bookingsQuery->clone()->get();
        $totalBookings = $filteredBookings->count();
        $totalRevenue = $filteredBookings->sum('total_price');

        // --- Chart Data ---

        // 1. Monthly Revenue for Selected Year (Using PostgreSQL EXTRACT)
        $monthlyRevenue = Booking::select(
                DB::raw('EXTRACT(MONTH FROM created_at) as month'), // <-- CORRECTED FUNCTION
                DB::raw('SUM(total_price) as revenue')
            )
            ->whereIn('status', $countedStatuses)
            ->whereYear('created_at', $selectedYear)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)')) // <-- CORRECTED GROUP BY
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)')) // <-- CORRECTED ORDER BY
            ->pluck('revenue', 'month') // Creates an associative array [month => revenue]
            ->all();

        // Prepare data for Chart.js (ensure all 12 months are present, default to 0)
        $revenueChartData = [];
        for ($m = 1; $m <= 12; $m++) {
            // Ensure the key is treated as an integer when accessing
            $revenueChartData[] = $monthlyRevenue[(int)$m] ?? 0;
        }

        // 2. Bookings per Car Type (for selected period)
        $bookingsByTypeQuery = Car::select('cars.body_type', DB::raw('count(bookings.id) as count'))
            ->join('bookings', 'cars.id', '=', 'bookings.car_id')
            ->whereIn('bookings.status', $countedStatuses)
            ->whereYear('bookings.created_at', $selectedYear);

        if ($selectedMonth) {
            $bookingsByTypeQuery->whereMonth('bookings.created_at', $selectedMonth);
        }

        $bookingsByType = $bookingsByTypeQuery->groupBy('cars.body_type')
                                              ->pluck('count', 'body_type')
                                              ->all();


        // --- Table Data ---
        $mostRentedCars = Car::select('cars.brand', 'cars.model', DB::raw('count(bookings.id) as booking_count'))
            ->join('bookings', 'cars.id', '=', 'bookings.car_id')
            ->whereIn('bookings.status', $countedStatuses)
            ->groupBy('cars.id', 'cars.brand', 'cars.model')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get();

        $recentBookings = Booking::with('car', 'user')
            ->latest()
            ->limit(5)
            ->get();

        // --- Data for View ---
        $availableYears = Booking::select(DB::raw('EXTRACT(YEAR FROM created_at) as year')) // Use EXTRACT here too for consistency
                                ->distinct()
                                ->orderBy('year', 'desc')
                                ->pluck('year')
                                ->toArray();
        if (empty($availableYears)) { $availableYears[] = $currentYear; }


        return view('admin.dashboard', compact(
            'totalCars',
            'totalBookings',
            'totalRevenue',
            'mostRentedCars',
            'recentBookings',
            'revenueChartData', // Data for revenue chart
            'bookingsByType',   // Data for car type chart
            'selectedYear',
            'selectedMonth',
            'availableYears'
        ));
    }
}