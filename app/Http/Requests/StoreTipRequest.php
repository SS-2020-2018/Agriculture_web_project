<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTipRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:4096'],
            'description' => ['required', 'string', 'max:3000'],
        ];
    }
}
