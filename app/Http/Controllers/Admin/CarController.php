<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(StoreCarRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $car = Car::create($validatedData);

            if ($request->hasFile('images')) {
                $isFirstImage = true;
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('car_images', 'public');
                    CarImage::create([
                        'car_id' => $car->id,
                        'path' => $path,
                        'is_thumbnail' => $isFirstImage,
                    ]);
                    $isFirstImage = false;
                }
            }
            DB::commit();
            return redirect()->route('admin.cars.index')->with('success', 'Car added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CAR STORE FAILED: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add car. Please try again.')->withInput();
        }
    }

    public function edit(Car $car)
    {
        $car->load('images');
        return view('admin.cars.edit', compact('car'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        DB::beginTransaction();
        try {
            // This line now works correctly because UpdateCarRequest validates ALL fields
            $car->update($request->validated());

            if ($request->has('thumbnail_id')) {
                $car->images()->update(['is_thumbnail' => false]);
                CarImage::where('id', $request->thumbnail_id)->update(['is_thumbnail' => true]);
            }

            if ($request->hasFile('images')) {
                $hasThumbnail = $car->images()->where('is_thumbnail', true)->exists();
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('car_images', 'public');
                    CarImage::create([
                        'car_id' => $car->id,
                        'path' => $path,
                        'is_thumbnail' => !$hasThumbnail,
                    ]);
                    $hasThumbnail = true;
                }
            }
            DB::commit();
            return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('CAR UPDATE FAILED: ' . $e->getMessage());
            return redirect()->back()->with('error', 'A critical error occurred. The incident has been logged.')->withInput();
        }
    }

    public function destroy(Car $car)
    {
        DB::beginTransaction();
        try {
            foreach ($car->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
            $car->delete();
            DB::commit();
            return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete car. Please try again.');
        }
    }

    public function destroyImage(CarImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    
    public function updateStatusMaintenance(Car $car)
    {
        try {
            $car->update(['status' => 'maintenance']);
            return redirect()->back()->with('success', 'Car status updated to Maintenance.');
        } catch (\Exception $e) {
            Log::error('CAR STATUS UPDATE FAILED (Maintenance): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update car status.');
        }
    }

    public function updateStatusArchived(Car $car)
    {
        try {
            $car->update(['status' => 'archived']);
            return redirect()->back()->with('success', 'Car has been archived.');
        } catch (\Exception $e) {
            Log::error('CAR STATUS UPDATE FAILED (Archived): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to archive car.');
        }
    }

    public function updateStatusAvailable(Car $car)
    {
        try {
            $car->update(['status' => 'available']);
            return redirect()->back()->with('success', 'Car status updated to Available.');
        } catch (\Exception $e) {
            Log::error('CAR STATUS UPDATE FAILED (Available): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update car status.');
        }
    }
}

