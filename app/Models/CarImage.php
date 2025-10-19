<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'car_images';

    /**
     * The attributes that are mass assignable.
     * This is the security whitelist.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_id',
        'path',
        'is_thumbnail', // This is the crucial permission
    ];

    /**
     * Get the car that owns the image.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}

