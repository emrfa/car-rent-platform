<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade; // <-- I ADDED THIS LINE

class CarController extends Controller
{
    public function home()
    {
        //dd(Blade::getClassComponentAliases()); DEBUG LINE

        // Fetch up to 5 random cars with images for the slideshow
        $slideshowCars = Car::with('images')
                      ->whereHas('images')
                      ->where('status', 'available')
                      ->inRandomOrder()
                      ->take(5)
                      ->get();

        return view('welcome', compact('slideshowCars'));
    }

   public function index(Request $request)
    {
        // Start the query, eager-loading the images and thumbnail
        $query = Car::with('images', 'thumbnail')
                    ->where('status', 'available');

        $searchTerm = $request->input('search');
        $currentFilter = $request->input('body_type', 'all'); // Get the filter, default to 'all'

        // 1. Apply search if it exists
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('brand', 'like', "%{$searchTerm}%")
                  ->orWhere('model', 'like', "%{$searchTerm}%")
                  ->orWhere('body_type', 'like', "%{$searchTerm}%");
            });
        }

        // 2. Apply body_type filter if it's not 'all'
        if ($currentFilter != 'all') {
            $query->where('body_type', $currentFilter);
        }

        // 3. Get paginated results and append all query parameters
        // This ensures search and filters work with pagination
        $cars = $query->latest()->paginate(12)->appends($request->all());

        // 4. Pass data to the view
        return view('cars.index', compact('cars', 'currentFilter'));
    }
    public function show(Car $car)
    {
        $car->load('images');
        return view('cars.show', compact('car'));
    }
}