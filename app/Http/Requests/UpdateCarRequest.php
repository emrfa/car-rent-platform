<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // ADDED ALL MISSING FIELDS TO THE VALIDATION RULES
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'body_type' => 'required|string|in:sedan,suv,mpv,hatchback',
            'seats' => 'required|integer|min:1',
            'fuel_type' => 'required|string|in:gasoline,diesel,electric,hybrid',
            'transmission' => 'required|string|in:manual,automatic',
            'year' => 'required|integer|digits:4',
            'license_plate' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cars')->ignore($this->car),
            ],
            'price_per_day' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:16384',
            'thumbnail_id' => 'nullable|integer|exists:car_images,id'
        ];
    }
}

