<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'body_type', 'seats', 'fuel_type', 'transmission', 'year', 'license_plate', 'price_per_day', 'status',
    ];

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    // A more robust helper method to get the thumbnail image
    public function thumbnail()
    {
        // This relationship specifically finds the one image marked as the thumbnail.
        return $this->hasOne(CarImage::class)->where('is_thumbnail', true);
    }

    // A fallback to get the first image if no thumbnail is set
    public function firstImage()
    {
        return $this->hasOne(CarImage::class)->oldest('id');
    }

    // Book Logic
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

