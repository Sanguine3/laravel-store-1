<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Session;

class ProcessCheckoutRequest extends BaseRequest
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
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|max:255',
            'phone'                => 'required|string|max:20',

            'shipping_address'     => 'required|string|max:1000',
            'billing_address'      => 'nullable|string|max:1000',

            'payment_method'       => 'required|string|max:50',
            'notes'                => 'nullable|string|max:2000',

            'receive_email_confirmation' => 'nullable|boolean',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @throws AuthorizationException
     */
    protected function failedAuthorization()
    {
        parent::failedAuthorization();
    }
} 