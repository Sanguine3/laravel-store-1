<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $common = [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];

        if ($this->isMethod('POST')) {
            return array_merge($common, [
                'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:categories,slug'],
            ]);
        }

        $categoryId = $this->route('category')?->id;
        return array_merge($common, [
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('categories', 'slug')->ignore($categoryId)],
        ]);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('name') && !$this->input('slug')) {
            $this->merge(['slug' => Str::slug($this->input('name'))]);
        }
    }

    /**
     * Customize the validated data.
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        if (!isset($data['slug']) && $this->has('slug')) {
            $data['slug'] = $this->input('slug');
        } elseif (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $data;
    }
} 