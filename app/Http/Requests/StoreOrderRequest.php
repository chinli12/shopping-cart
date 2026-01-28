<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1', 'max:100'],
            'items.*.id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'email' => ['nullable', 'email'],
        ];
    }

 
    public function messages(): array
    {
        return [
            'items.required' => 'Order must contain at least one item.',
            'items.*.id.required' => 'Product ID is required for each item.',
            'items.*.id.exists' => 'One or more products do not exist.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}