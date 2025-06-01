<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProductRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $common = [
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'price'          => ['required', 'numeric', 'min:0'],
            'image_url'      => ['nullable', 'url', 'max:2048'],
            'category_id'    => ['required', 'exists:categories,id'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'is_published'   => ['sometimes', 'boolean'],
        ];

        if ($this->isMethod('POST')) {
            return array_merge($common, [
                'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:products,slug'],
            ]);
        }

        $productId = $this->route('product')?->id;
        return array_merge($common, [
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('products', 'slug')->ignore($productId)],
        ]);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $name = $this->input('name');
        $slug = $this->input('slug');

        if ($name && !$slug) {
            $this->merge(['slug' => Str::slug($name)]);
        }

        $this->merge(['is_published' => $this->boolean('is_published')]);
    }

    /**
     * Customize the validated data.
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        $data['image'] = $data['image_url'] ?? null;
        unset($data['image_url']);
        return $data;
    }
} 