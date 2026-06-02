<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,processing,ready,picked-up,cancelled'],
        ];
    }
}
