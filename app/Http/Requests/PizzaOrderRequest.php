<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PizzaOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'size' => ['required', 'in:small,medium,large'],
            'pepperoni' => ['nullable', 'boolean'],
            'extra_cheese' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => 'Please enter your name.',
            'size.required' => 'Please select a pizza size.',
            'size.in' => 'Invalid pizza size selected.',
        ];
    }
}
