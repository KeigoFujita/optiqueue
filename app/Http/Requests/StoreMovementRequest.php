<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'movement_type' => ['required', 'string', 'in:in,out'],
            'movement_category' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'movement_date' => ['required', 'date'],
            'reference_id' => ['nullable', 'string', 'max:255'],
        ];
    }
}
