<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $common = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role'  => ['required', 'string', Rule::in(['admin', 'customer'])],
        ];

        if ($this->isMethod('POST')) {
            return array_merge($common, [
                'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
        }

        $userId = $this->route('user')?->id;
        return array_merge($common, [
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)->whereNull('deleted_at')],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);
    }

    /**
     * Customize the validated data (hash password if provided).
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        return $data;
    }
} 