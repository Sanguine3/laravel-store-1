<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
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

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'price'       => $this->faker->randomFloat(2, 10, 200),
            'description' => $this->faker->paragraph,
            // Generate a relative image path instead of a full URL to reflect how the image upload stores the file path.
            'image_url'   => '/storage/products/' . $this->faker->image('public/storage/products', 300, 300, 'products', false),
            'category_id' => $categoryId,
        ];
    }
}
?>
