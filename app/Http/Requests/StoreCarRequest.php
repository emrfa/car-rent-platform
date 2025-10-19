<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        // For now, we'll allow any authenticated user.
        // We will add admin-only logic later.
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'body_type' => 'required|string|in:sedan,suv,mpv,hatchback',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|string|in:gasoline,diesel,electric,hybrid',
            'year' => 'required|integer|digits:4',
            'license_plate' => 'required|string|max:255|unique:cars,license_plate',
            'price_per_day' => 'required|numeric|min:0',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:16384' // Increased to 16MB
        ];
    }
}