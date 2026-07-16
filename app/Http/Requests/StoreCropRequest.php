<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCropRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Any authenticated farmer may register a crop for themselves.
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'planting_date' => ['required', 'date'],
            'expected_harvest_date' => ['required', 'date', 'after_or_equal:planting_date'],
            'land_area' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:growing,ready_for_harvest,harvested'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
    /*@return array<string, string>*/
    public function messages(): array
    {
        return [
            'image.required' => 'Please upload a photo of your crop.',
            'expected_harvest_date.after_or_equal' => 'The expected harvest date must be on or after the planting date.',
        ];
    }
}
