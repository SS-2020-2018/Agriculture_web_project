<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
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
            'answer_text' => ['required', 'string', 'max:2000'],
        ];
    }
}
