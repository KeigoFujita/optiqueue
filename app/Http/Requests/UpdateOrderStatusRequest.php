<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,processing,ready,picked-up,cancelled'],
        ];
    }
}
