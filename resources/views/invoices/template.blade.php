<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice #{{ $booking->id }}</title>
  <style>
    @page { margin: 0; }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      margin: 40px;
      color: #333;
      background-color: #f5f5f5;
    }
    .invoice-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .header {
      border-bottom: 2px solid #1d4ed8;
      padding-bottom: 15px;
      margin-bottom: 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .header h1 {
      font-size: 26px;
      color: #1d4ed8;
      margin: 0;
    }
    .company-info {
      text-align: right;
      font-size: 14px;
      color: #555;
    }
    .section-title {
      font-weight: bold;
      color: #1d4ed8;
      margin-bottom: 10px;
      border-bottom: 1px solid #ddd;
      display: inline-block;
      padding-bottom: 3px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      font-size: 14px;
    }
    th, td {
      border: 1px solid #e5e7eb;
      padding: 10px;
    }
    th {
      background-color: #f0f4ff;
      color: #1e3a8a;
      text-align: left;
      font-weight: 600;
    }
    td {
      background-color: #fff;
    }
    .summary {
      margin-top: 25px;
      text-align: right;
    }
    .summary table {
      width: 40%;
      float: right;
      border: none;
    }
    .summary th {
      background-color: transparent;
      color: #333;
      text-align: left;
      font-weight: normal;
      border: none;
    }
    .summary td {
      text-align: right;
      font-weight: bold;
      border: none;
    }
    .summary .total td {
      color: #1d4ed8;
      font-size: 16px;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #888;
      margin-top: 60px;
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }
  </style>
</head>
<body>
  <div class="invoice-container">
    <div class="header">
      <h1>CarRent</h1>
      <div class="company-info">
        <div>CarRent Headquarters</div>
        <div>Jakarta, Indonesia</div>
        <div>support@carrent.com</div>
      </div>
    </div>

    <div class="customer-info">
  <div class="section-title">Invoice To:</div>
  <p>
    <strong>{{ $booking->user->name ?? 'Customer' }}</strong><br><br>
    {{ $booking->user->email ?? '-' }}
  </p>
</div>


    <div class="booking-info" style="margin-top: 25px;">
      <div class="section-title">Booking Details</div>
      <table>
        <tr>
          <th>Booking ID</th>
          <td>#{{ $booking->id }}</td>
        </tr>
        <tr>
          <th>Car</th>
          <td>{{ $booking->car->brand ?? '' }} {{ $booking->car->model ?? 'N/A' }}</td>
        </tr>
        <tr>
          <th>Start Date</th>
          <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</td>
        </tr>
        <tr>
          <th>End Date</th>
          <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</td>
        </tr>
        <tr>
          <th>Status</th>
          <td>{{ ucfirst($booking->status ?? 'Pending') }}</td>
        </tr>
      </table>
    </div>

    <div class="summary">
        <div class="section-title" style="border: none; margin-bottom: 0; text-align: right;">Price Breakdown</div>
        <table>
            @php
                // Recalculate components based on booking data
                $startDate = \Carbon\Carbon::parse($booking->start_date);
                $endDate = \Carbon\Carbon::parse($booking->end_date);
                $days = $startDate->diffInDays($endDate) + 1;
                $carPricePerDay = $booking->car->price_per_day ?? 0;
                $carSubtotal = $days * $carPricePerDay;
                $insuranceCost = $booking->insurance_cost ?? 0;
                // Infer driver fee assuming total_price = car_subtotal + insurance + driver
                $driverFee = max(0, $booking->total_price - $carSubtotal - $insuranceCost); // Ensure it's not negative
            @endphp
            <tr>
                <th>Car Rental ({{ $days }} day(s))</th>
                {{-- Use &nbsp; --}}
                <td>Rp&nbsp;{{ number_format($carSubtotal, 0, ',', '.') }}</td>
            </tr>
            @if($insuranceCost > 0)
            <tr>
                <th>Insurance ({{ ucfirst($booking->insurance_type ?? 'Basic') }})</th>
                {{-- Use &nbsp; --}}
                <td>Rp&nbsp;{{ number_format($insuranceCost, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($driverFee > 0)
            <tr>
                <th>Driver Fee ({{ $days }} day(s))</th>
                {{-- Use &nbsp; --}}
                <td>Rp&nbsp;{{ number_format($driverFee, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total">
                <th>Grand Total</th>
                {{-- Use &nbsp; --}}
                <td>Rp&nbsp;{{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div style="clear:both;"></div>

    <div class="footer">
      Thank you for choosing CarRent.<br>
      For support, contact <strong>support@carrent.com</strong>
    </div>
  </div>
</body>
</html>
