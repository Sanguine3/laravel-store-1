<?php

namespace App\Http\Requests\Customer\Checkout;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class ProcessCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && !empty(Session::get('cart', []));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // For communication/confirmation, not directly on Order model by default
            'email' => 'required|email|max:255', // For communication/confirmation
            'phone' => 'required|string|max:20',  // For communication/confirmation

            'shipping_address' => 'required|string|max:1000', // Single field for shipping address
            'billing_address' => 'nullable|string|max:1000', // Single field, optional

            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string|max:2000', // Customer notes

            'receive_email_confirmation' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter your phone number.',
            'shipping_address.required' => 'Please enter your shipping address.',
            'payment_method.required' => 'Please select or enter a payment method.',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        // Basic handling, actual redirect or detailed error should be managed by controller or exception handler
        parent::failedAuthorization();
    }
}
