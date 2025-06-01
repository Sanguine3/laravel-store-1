<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getPaginated(int $perPage = 15)
    {
        return Product::paginate($perPage);
    }

    public function get(int $id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }
} 