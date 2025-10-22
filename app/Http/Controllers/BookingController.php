<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use App\Events\BookingCreated; 
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{

    private function generateInvoicePdf(Booking $booking)
    {
        // Ensure relationships are loaded
        $booking->loadMissing(['car', 'user']);

        // Generate PDF using the template view
        return Pdf::loadView('invoices.template', compact('booking'))
                  ->setPaper('A4', 'portrait');
    }

    /**
     * Generate and download the invoice PDF.
     */
    public function downloadInvoice(Booking $booking): Response // Use Route Model Binding
    {
        // Authorization check
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') { // Allow admin too
            abort(403, 'Unauthorized access');
        }

        $pdf = $this->generateInvoicePdf($booking);
        $filename = 'invoice-booking-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        // Return download response
        return $pdf->download($filename);
    }

   public function sendInvoiceEmail(Booking $booking) // Use Route Model Binding
    {
        // Authorization check
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') { // Allow admin too
            abort(403, 'Unauthorized access');
        }

        // Ensure user relationship is loaded for email address
        $booking->loadMissing('user');

        if (!$booking->user || !$booking->user->email) {
            return back()->with('error', 'Cannot send invoice: User email not found.');
        }

        $pdf = $this->generateInvoicePdf($booking);

        try {
            Mail::send('emails.invoice', ['booking' => $booking], function ($message) use ($booking, $pdf) {
                $message->to($booking->user->email)
                        ->subject('Your CarRent Invoice #' . $booking->id)
                        ->attachData($pdf->output(), 'invoice-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) . '.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });

            return back()->with('success', 'Invoice sent successfully to ' . $booking->user->email . '!');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to send invoice email for booking #' . $booking->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to send invoice. Please try again later.');
        }
    }

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
        // $isUnavailable = Booking::where('car_id', $car->id)
        //     ->where('status', 'confirmed') // Check against confirmed bookings
        //     ->where(function ($query) use ($startDate, $endDate) {
        //          $query->where(function ($q) use ($startDate, $endDate) { /* ...overlap logic... */ })
        //                ->orWhere(function ($q) use ($startDate, $endDate) { /* ...overlap logic... */ })
        //                ->orWhere(function ($q) use ($startDate, $endDate) { /* ...overlap logic... */ });
        //     })
        //     ->exists();

        // if ($isUnavailable) {
        //     throw ValidationException::withMessages([
        //         'start_date' => 'Sorry, the selected dates overlap with an existing booking. Please choose different dates.',
        //     ]);
        // } commented for debug

        Log::info('Checking availability for Car ID: ' . $car->id . ' between ' . $startDate->toDateString() . ' and ' . $endDate->toDateString());

        $conflictingBookings = Booking::where('car_id', $car->id)
            ->where('status', 'confirmed')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '>=', $startDate)
                      ->where('start_date', '<', $endDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('end_date', '>', $startDate)
                      ->where('end_date', '<=', $endDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<', $startDate)
                      ->where('end_date', '>', $endDate);
                });
            })
            // ->exists(); // <-- Temporarily change from exists() to get()
            ->get(); // <-- Get the actual conflicting bookings (if any)

        // Check if the collection is NOT empty
        if ($conflictingBookings->isNotEmpty()) {
            // Log the bookings found
            Log::error('Conflict detected! Existing bookings found:', $conflictingBookings->toArray());

             // --- Use dd() to stop execution and see the conflicting bookings ---
             dd('Conflict detected!', $conflictingBookings->toArray(), $startDate, $endDate); // <-- UNCOMMENT THIS LINE FOR IMMEDIATE DEBUGGING

            // Throw the exception (keep this for normal flow after debugging)
             throw ValidationException::withMessages([
                 'start_date' => 'Sorry, the selected dates overlap with an existing booking. Please choose different dates.',
             ]);
        }
        // --- END TEMPORARY DEBUGGING ---

        // 3. Price Calculation
        $days = $startDate->diffInDays($endDate) + 1;
        $carPrice = $days * $car->price_per_day;
        $insuranceCosts = ['none' => 0, 'basic' => 50000, 'full' => 100000];
        $insuranceCost = $days * ($insuranceCosts[$insuranceType] ?? 0);
        $driverFee = ($validated['with_driver']) ? $days * 200000 : 0;
        $totalPrice = $carPrice + $insuranceCost + $driverFee;

        // 4. Create the Booking
        try {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'car_id' => $car->id,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_price' => $totalPrice,
                'status' => 'confirmed',
                'insurance_type' => $insuranceType,
                'insurance_cost' => $insuranceCost,
            ]);

            // ----> DISPATCH THE EVENT <----
            BookingCreated::dispatch($booking);
            // ----> END DISPATCH <----

            // 5. Redirect to Confirmation Page
            return redirect()->route('booking.show', $booking)
                             ->with('success', 'Your booking has been confirmed! Details below. An invoice will be sent to your email shortly.'); // Update success message for queue

        } catch (\Exception $e) {
             Log::error('Booking creation failed: ' . $e->getMessage()); // Log only booking failure now
             if ($e instanceof ValidationException) { // Re-check if it's the availability error
                 return back()->withErrors($e->errors())->withInput();
             }
             // Don't mention invoice sending failure here
             return back()->with('error', 'Failed to create booking. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified booking confirmation.
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