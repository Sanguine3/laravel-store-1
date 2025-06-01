<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Libraries\Common;

class BaseRequest extends FormRequest
{
    /**
     * Only authenticated users are authorized by default.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Sanitize all input before validation.
     */
    protected function prepareForValidation(): void
    {
        $sanitized = Common::sanitizeInput($this->all());
        $this->merge($sanitized);
    }
} 