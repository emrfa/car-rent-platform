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
        $countedStatuses = ['confirmed', 'completed']; // *** CHANGED: Include 'completed' ***

        // --- Basic Stats ---
        $totalCars = Car::count();

        // Query builder for filtered bookings (using counted statuses)
        $bookingsQuery = Booking::whereIn('status', $countedStatuses) // *** Use whereIn ***
                                ->whereYear('created_at', $selectedYear);
        if ($selectedMonth) {
            $bookingsQuery->whereMonth('created_at', $selectedMonth);
        }

        $filteredBookings = $bookingsQuery->clone()->get();
        $totalBookings = $filteredBookings->count(); // Total confirmed + completed bookings in period
        $totalRevenue = $filteredBookings->sum('total_price'); // Total revenue from confirmed + completed

        // --- Chart Data ---

        // 1. Monthly Revenue for Selected Year (using counted statuses)
        $monthlyRevenue = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->whereIn('status', $countedStatuses) // *** Use whereIn ***
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->all();

        $revenueChartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $revenueChartData[] = $monthlyRevenue[$m] ?? 0;
        }

        // 2. Bookings per Car Type (using counted statuses)
        $bookingsByTypeQuery = Car::select('cars.body_type', DB::raw('count(bookings.id) as count'))
            ->join('bookings', 'cars.id', '=', 'bookings.car_id')
            ->whereIn('bookings.status', $countedStatuses) // *** Use whereIn ***
            ->whereYear('bookings.created_at', $selectedYear);

        if ($selectedMonth) {
            $bookingsByTypeQuery->whereMonth('bookings.created_at', $selectedMonth);
        }

        $bookingsByType = $bookingsByTypeQuery->groupBy('cars.body_type')
                                              ->pluck('count', 'body_type')
                                              ->all();

        // --- Table Data ---
        // Most Rented (Consider using counted statuses here too for consistency)
         $mostRentedCars = Car::select('cars.brand', 'cars.model', DB::raw('count(bookings.id) as booking_count'))
            ->join('bookings', 'cars.id', '=', 'bookings.car_id')
            ->whereIn('bookings.status', $countedStatuses) // *** Use whereIn ***
            ->groupBy('cars.id', 'cars.brand', 'cars.model')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get();

        // Recent Bookings (Keep showing all recent, regardless of status for this table)
        $recentBookings = Booking::with('car', 'user')
            ->latest()
            ->limit(5)
            ->get();

        // --- Data for View ---
        $availableYears = Booking::select(DB::raw('YEAR(created_at) as year'))
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
            'revenueChartData',
            'bookingsByType',
            'selectedYear',
            'selectedMonth',
            'availableYears'
        ));
    }
}