<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFertilizerRequest extends FormRequest
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
            'crop_name' => ['required', 'string', 'max:255'],
            'crop_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'fertilizers' => ['required', 'string', 'max:255'],
            'application_stage' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'string', 'max:255'],
            'application_method' => ['required', 'string', 'max:255'],
            'usage_instructions' => ['required', 'string', 'max:2000'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
