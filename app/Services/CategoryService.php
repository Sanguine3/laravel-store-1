<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getPaginated(int $perPage = 15)
    {
        return Category::paginate($perPage);
    }

    public function get(int $id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }
} 