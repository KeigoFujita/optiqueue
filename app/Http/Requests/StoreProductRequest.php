<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'category' => ['required', 'string', 'in:men,women,lenses,accessories'],
            'type' => ['required', 'string', 'in:frame,lens,accessory'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,avif', 'max:2048'],
            'icon' => ['nullable', 'string', 'max:50'],
            'badge' => ['nullable', 'string', 'max:255'],
            'badge_color' => ['nullable', 'string', 'max:20'],
            'stocks' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,archived'],
        ];
    }
}
