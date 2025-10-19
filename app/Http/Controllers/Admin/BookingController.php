<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'car'])
                       ->latest('start_date'); 

        $bookings = $query->paginate(15); 

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        
        $booking->load(['user', 'car']);

        // Define possible statuses
        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        return view('admin.bookings.edit', compact('booking', 'statuses'));
    }

    /**
     * Update the specified booking in storage.
     * This will handle both general updates and cancellations via status change.
     */
    public function update(Request $request, Booking $booking)
    {
        // Basic validation for status
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
        ]);
        try {
            $booking->update($validated);
            return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Booking update failed: ' . $e->getMessage()); // Log the error
            return redirect()->back()->with('error', 'Failed to update booking. Please try again.');
        }
    }

    /**
     * Remove the specified booking from storage (Optional - Use status update instead).
     */
    // public function destroy(Booking $booking)
    // {
    //     try {
    //         $booking->delete();
    //         return redirect()->route('admin.bookings.index')->with('success', 'Booking permanently deleted.');
    //     } catch (\Exception $e) {
    //          \Log::error('Booking deletion failed: '.$e->getMessage());
    //         return redirect()->back()->with('error', 'Failed to delete booking.');
    //     }
    // }
}