<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update an admin user.
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                // Make sure you set a secure password here.
                'password' => bcrypt('adminPassword123'),
                'role'     => 'admin',
            ]
        );

        // Create several customer users.
        User::factory(5)->create();

        // Manually create specific categories
        $categories = collect([
            ['name' => 'Apparel', 'slug' => 'apparel', 'description' => 'T-shirts, Hoodies, and more'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Mugs, Stickers, Hats, etc.'],
            ['name' => 'Digital', 'slug' => 'digital', 'description' => 'Ebooks, Presets, Wallpapers, and other digital goods'],
        ])->map(function($data) {
            return Category::create($data);
        });

        // -------------------------------------------------
        // Manually add some sample product entries with sample data.
        // -------------------------------------------------
        $sampleProducts = [
            [
                'name'           => 'Vintage Sweatshirt',
                'price'          => 34.99,
                'description'    => 'Trendy and comfy, perfect for casual days.',
                'image'          => 'https://via.placeholder.com/300x300.png?text=Vintage+Sweatshirt',
                'category_slug'  => 'apparel',
            ],
            [
                'name'           => 'Leather Bracelet',
                'price'          => 14.99,
                'description'    => 'Cool accessory to complement any outfit.',
                'image'          => 'https://via.placeholder.com/300x300.png?text=Leather+Bracelet',
                'category_slug'  => 'accessories',
            ],
            [
                'name'           => 'Digital Art Pack',
                'price'          => 9.99,
                'description'    => 'A small bundle of trendy digital wallpapers.',
                'image'          => 'https://via.placeholder.com/300x300.png?text=Digital+Art+Pack',
                'category_slug'  => 'digital',
            ],
            [
                'name'           => 'Casual Cap',
                'price'          => 12.49,
                'description'    => 'Lightweight cap for sunny days.',
                'image'          => 'https://via.placeholder.com/300x300.png?text=Casual+Cap',
                'category_slug'  => 'accessories',
            ],
            [
                'name'           => 'Eco-Friendly T-Shirt',
                'price'          => 19.95,
                'description'    => 'Sustainable fabric, modern fit.',
                'image'          => 'https://via.placeholder.com/300x300.png?text=Eco+Friendly+T-Shirt',
                'category_slug'  => 'apparel',
            ]
        ];

        foreach ($sampleProducts as $sampleProduct) {
            $category = Category::where('slug', $sampleProduct['category_slug'])->first();
            if ($category) {
                Product::create([
                    'name'        => $sampleProduct['name'],
                    'slug'        => Str::slug($sampleProduct['name']),
                    'price'       => $sampleProduct['price'],
                    'description' => $sampleProduct['description'],
                    'image_url'   => $sampleProduct['image'],
                    'category_id' => $category->id,
                ]);
            }
        }

        // For each category, create additional products using factory.
        // Let's create 7 products per category to have more data.
        $categories->each(function ($category) {
            Product::factory(7)->create([
                'category_id' => $category->id,
            ]);
        });

        // Fetch all customer users (excluding admin).
        $customers = User::where('role', 'customer')->get();

        // Create sample orders for each customer.
        foreach ($customers as $customer) {
            // Each customer gets 2 orders.
            $orders = Order::factory(2)->create([
                'user_id' => $customer->id,
            ]);

            // For each order, add between 1 and 3 order items.
            $products = Product::all();
            foreach ($orders as $order) {
                $randomProducts = $products->random(rand(1, 3));
                foreach ($randomProducts as $product) {
                    OrderItem::factory()->create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        // The factory should set quantity and capture the correct product price.
                    ]);
                }
            }
        }

        // Optionally, create a sample test user.
        User::factory()->create([
            'name'  => 'Test User 1',
            'email' => 'test@example.com',
        ]);
    }
}
?>
