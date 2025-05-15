<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get a random category id if available
        $categoryId = Category::query()->inRandomOrder()->value('id');

        // Generate a product name and corresponding slug.
        $name = $this->faker->words(3, true);
        $name = Str::title($name); // Capitalize words for better presentation

        // Define the physical storage path for product images
        $storagePath = 'public/products'; // This corresponds to storage/app/public/products

        // Ensure the directory exists
        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath);
        }

        // Generate image and get just the filename
        // Faker will save it to storage/app/public/products/
        $imageFileName = $this->faker->image(Storage::path($storagePath), 300, 300, 'products', false);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'price'       => $this->faker->randomFloat(2, 10, 200),
            'description' => $this->faker->paragraph,
            // Store the publicly accessible path in the 'image' column
            'image'       => $imageFileName ? 'products/' . $imageFileName : null, // Relative to public/storage
            'category_id' => $categoryId,
            // Add other fields your product might have, e.g., stock_quantity
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'is_published' => $this->faker->boolean(80), // 80% chance of being published
        ];
    }
}
