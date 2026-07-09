<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReminderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /*
     @return array<string, mixed>
    */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'reminder_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
