<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketPriceRequest extends FormRequest
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
            'market_name' => ['required', 'string', 'max:255'],
            'price_per_unit' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'unit' => ['required', 'string', 'max:50'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
