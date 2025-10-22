<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; color: #333; }
  </style>
</head>
<body>
  <p>Hi {{ $booking->user->name ?? 'Customer' }},</p>

  <p>Thank you for booking with <strong>CarRent</strong>!</p>

  <p>Your booking invoice is attached to this email.</p>

  <p>
    <strong>Booking ID:</strong> #{{ $booking->id }}<br>
    <strong>Car:</strong> {{ $booking->car->brand ?? '' }} {{ $booking->car->model ?? 'N/A' }}<br>
    <strong>Total:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}
  </p>

  <p>We appreciate your business and hope to serve you again soon!</p>

  <p>– The CarRent Team 🚗</p>
</body>
</html>
