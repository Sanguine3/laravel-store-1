<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Assuming any authenticated admin user can update order statuses
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Define possible statuses
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

        return [
            'status' => ['required', 'string', Rule::in($statuses)],
        ];
    }
} 