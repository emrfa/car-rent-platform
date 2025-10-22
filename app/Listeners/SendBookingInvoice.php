<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Notifications\BookingInvoiceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Notification;

class SendBookingInvoice
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;
        $booking->loadMissing('user');
        $user = $booking->user;

        if ($user && $user->email) {
            try {
                Notification::send($user, new BookingInvoiceNotification($booking));
                Log::info('Booking invoice notification queued/sent for booking ID: ' . $booking->id);
            } catch (\Exception $e) {
                Log::error('Failed to queue/send booking invoice notification for booking ID ' . $booking->id . ': ' . $e->getMessage());
            }
        } else {
            Log::warning('SendBookingInvoice listener: User or email missing for booking ID: ' . $booking->id);
        }
    }
}