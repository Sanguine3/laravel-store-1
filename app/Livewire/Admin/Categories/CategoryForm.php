<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.app')]
class CategoryForm extends Component
{
    public ?Category $category = null;
    public $allCategories; // For parent category dropdown

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('nullable|string|max:255')]
    public string $slug = '';

    #[Rule('nullable|string')]
    public string $description = '';

    public function mount(?int $id = null): void
    {
        $this->allCategories = Category::query()->orderBy('name')->get();
        if ($id) {
            $this->category = Category::findOrFail($id);
            $this->name = $this->category->name;
            $this->slug = $this->category->slug;
            $this->description = $this->category->description;
        }
    }

    /**
     * Generate a slug from the given name using a standard convention.
     * Ensures only lowercase letters, numbers, and hyphens.
     */
    protected function generateSlug(string $name): string
    {
        // Use Laravel's Str::slug helper for consistency
        return \Str::slug($name);
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        // Generate slug if not provided or empty
        $validated['slug'] = $validated['slug'] ?: $this->generateSlug($validated['name']);
        if ($this->category) {
            $this->category->update($validated);
            session()->flash('status', 'Category updated successfully.');
            // Stay on edit page
            return null;
        } else {
            Category::create($validated);
            session()->flash('status', 'Category created successfully.');
            // Redirect to category list
            return redirect()->route('admin.categories');
        }
    }

    public function deleteCategory()
    {
        if ($this->category) {
            $this->category->delete();
            session()->flash('status', 'Category deleted successfully.');
            return redirect()->route('admin.categories');
        }
    }

    public function render()
    {
        return view('livewire.admin.categories.form', [
            'categories' => $this->allCategories,
        ]);
    }
}
