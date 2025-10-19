<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Import Auth
use Carbon\Carbon;
use Illuminate\Validation\ValidationException; // <-- Import ValidationException

class BookingController extends Controller
{


    public function index()
    {
        $userId = Auth::id();
        $bookings = Booking::where('user_id', $userId)
                           ->with('car') // Load car details
                           ->orderBy('start_date', 'desc')
                           ->paginate(10); // Paginate results

        return view('bookings.index', compact('bookings'));
    }


    /**
     * Show the form for creating a new booking.
     */
    public function create(Car $car)
    {
        // Get all confirmed bookings for this car that are in the future
        $confirmedBookings = Booking::where('car_id', $car->id)
                                    ->where('status', 'confirmed') // Consider adding other blocking statuses like 'pending_payment' if applicable
                                    ->where('end_date', '>=', Carbon::today())
                                    ->get();

        // Format dates for the JavaScript calendar
        $unavailableDates = [];
        foreach ($confirmedBookings as $booking) {
            $period = Carbon::parse($booking->start_date)->toPeriod($booking->end_date);
            foreach ($period as $date) {
                $unavailableDates[] = $date->format('Y-m-d');
            }
        }
        // Ensure unique dates
        $unavailableDates = array_unique($unavailableDates);

        return view('cars.booking', [
            'car' => $car,
            'unavailableDates' => $unavailableDates
        ]);
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request, Car $car)
    {
        // 1. Basic Validation
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'with_driver' => 'required|boolean',
            'insurance_type' => 'required|string|in:none,basic,full',
            'tos_agree' => 'required|accepted',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $insuranceType = $validated['insurance_type'];

        // 2. Critical Availability Check (backend)
        $isUnavailable = Booking::where('car_id', $car->id)
            ->where('status', 'confirmed') // Check against confirmed bookings
            // Check for overlaps
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    // Existing starts within new range (excluding exact end date match)
                    $q->where('start_date', '>=', $startDate)
                      ->where('start_date', '<', $endDate); // Use '<' to allow booking starting day after previous ends
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    // Existing ends within new range (excluding exact start date match)
                    $q->where('end_date', '>', $startDate) // Use '>' to allow booking ending day before previous starts
                      ->where('end_date', '<=', $endDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    // Existing encloses new range
                    $q->where('start_date', '<', $startDate)
                      ->where('end_date', '>', $endDate);
                });
            })
            ->exists();

        if ($isUnavailable) {
            // Send the user back with an error if dates clash
            throw ValidationException::withMessages([
                'start_date' => 'Sorry, the selected dates overlap with an existing booking. Please choose different dates.',
            ]);
        }

        // 3. Price Calculation
        $days = $startDate->diffInDays($endDate) + 1;
        $carPrice = $days * $car->price_per_day;

        $insuranceCosts = [
            'none' => 0,
            'basic' => 50000,
            'full' => 100000,
        ];
        $insuranceCost = $days * ($insuranceCosts[$insuranceType] ?? 0);

        $driverFee = ($validated['with_driver']) ? $days * 200000 : 0;
        $totalPrice = $carPrice + $insuranceCost + $driverFee;

        // 4. Create the Booking
        $booking = Booking::create([
            'user_id' => Auth::id(), // Get the logged-in user's ID
            'car_id' => $car->id,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'total_price' => $totalPrice,
            'status' => 'confirmed', // Consider 'pending' if payment step is needed
            'insurance_type' => $insuranceType,
            'insurance_cost' => $insuranceCost,
            // You might add 'driver_cost' => $driverFee here if you add the column later
        ]);

        // 5. Redirect to Confirmation Page
        return redirect()->route('booking.show', $booking)
                         ->with('success', 'Your booking has been confirmed! Details below.'); // Added more context to message
    }

    /**
     * Display the specified booking confirmation.
     * THIS METHOD WAS MISSING
     */
    public function show(Booking $booking)
    {
        // Ensure the logged-in user owns this booking to prevent others viewing it
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access'); // Provide a clearer error message
        }

        // Eager load related data for efficiency
        $booking->load('car', 'user');

        // Pass the booking data to the confirmation view
        return view('cars.booking-confirmation', compact('booking'));
    }
}