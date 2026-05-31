<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'frame_id' => ['nullable', 'integer', 'exists:products,id'],
            'lens_id' => ['nullable', 'integer', 'exists:products,id'],
            'accessory_id' => ['nullable', 'integer', 'exists:products,id'],
        ];
    }
}
