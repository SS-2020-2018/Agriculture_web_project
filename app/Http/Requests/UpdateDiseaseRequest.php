<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiseaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    /*
      @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'affected_crop' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'warning_level' => ['required', 'in:low,medium,high,critical'],
            'symptoms' => ['required', 'string', 'max:2000'],
            'preventive_measures' => ['required', 'string', 'max:2000'],
            'suggested_treatments' => ['required', 'string', 'max:2000'],
            'additional_recommendations' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
