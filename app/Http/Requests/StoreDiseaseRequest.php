<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiseaseRequest extends FormRequest
{
    /*
     Defense in depth — the /admin route group is already gated by the
     'admin' middleware, but we check again here in case this request
     class is ever reused on a route that isn't.
     */
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
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'warning_level' => ['required', 'in:low,medium,high,critical'],
            'symptoms' => ['required', 'string', 'max:2000'],
            'preventive_measures' => ['required', 'string', 'max:2000'],
            'suggested_treatments' => ['required', 'string', 'max:2000'],
            'additional_recommendations' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
