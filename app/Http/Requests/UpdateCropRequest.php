<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCropRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ownership is enforced separately in the controller via
        // $this->authorize('update', $crop) against CropPolicy.
        return true;
    }

    /*
      @return array<string, mixed>
    */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Optional on update — the farmer only needs to upload a new
            // image if they actually want to replace the existing one.
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'planting_date' => ['required', 'date'],
            'expected_harvest_date' => ['required', 'date', 'after_or_equal:planting_date'],
            'land_area' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:growing,ready_for_harvest,harvested'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /*
      @return array<string, string>
    */
    public function messages(): array
    {
        return [
            'expected_harvest_date.after_or_equal' => 'The expected harvest date must be on or after the planting date.',
        ];
    }
}
