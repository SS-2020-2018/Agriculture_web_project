<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:rain_alert,government_notice,disease_pest_alert,new_farming_method'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'description' => ['required', 'string', 'max:5000'],
        ];
    }
}
