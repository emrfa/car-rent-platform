<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; 
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking; 
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log; 

class BookingInvoiceNotification extends Notification implements ShouldQueue 
{
    use Queueable;

    public Booking $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking) // <-- Accept Booking
    {
        $this->booking = $booking; // <-- Assign Booking
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // Send via email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            $this->booking->loadMissing(['user', 'car']);

            $pdf = Pdf::loadView('invoices.template', ['booking' => $this->booking]);
            $filename = 'invoice-booking-' . str_pad($this->booking->id, 6, '0', STR_PAD_LEFT) . '.pdf';

            Log::info("Generating email for booking ID: {$this->booking->id}");

            // Build the email message
            return (new MailMessage)
                        ->subject('Your CarRent Invoice #' . $this->booking->id)
                        ->view('emails.invoice', ['booking' => $this->booking])
                        ->attachData($pdf->output(), $filename, [
                            'mime' => 'application/pdf',
                        ]);

        } catch (\Exception $e) {
            // Log errors during PDF generation or email building
            Log::error("Error preparing BookingInvoiceNotification for booking {$this->booking->id}: " . $e->getMessage());
            // Return a basic error email instead? Or let the job fail/retry
             return (new MailMessage)
                        ->subject('Problem Generating Invoice for Booking #' . $this->booking->id)
                        ->line('We encountered an error while preparing the invoice for your recent booking.')
                        ->line('Please contact support if you require assistance.');
        }
    }

    /**
     * Handle a job failure. (Optional but recommended)
    */
    public function failed(\Throwable $exception): void
    {
         // Log if the notification job fails entirely
        Log::critical("BookingInvoiceNotification FAILED for booking {$this->booking->id}: " . $exception->getMessage());
    }
}