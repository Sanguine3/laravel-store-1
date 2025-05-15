<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // Keep Str for potential slug generation if not handled by factory/observer

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the seeder for the admin user
        $this->call(AdminUserSeeder::class);

        // Create customer users using the factory
        // Let's create 10 customer users for more variety
        User::factory(10)->create(['role' => 'customer']);

        // Create categories: 3 manually defined, and a few more via factory
        $manualCategories = collect([
            ['name' => 'Apparel', 'slug' => 'apparel', 'description' => 'T-shirts, Hoodies, and more'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Mugs, Stickers, Hats, etc.'],
            ['name' => 'Digital Goods', 'slug' => 'digital-goods', 'description' => 'Ebooks, Presets, Wallpapers'],
        ])->map(function($data) {
            return Category::updateOrCreate(['slug' => $data['slug']], $data);
        });

        // Create a few additional random categories using the factory
        $factoryCategories = Category::factory(3)->create();
        $allCategories = $manualCategories->merge($factoryCategories);

        // Create products for each category using the factory
        // Each category will have between 5 to 10 products
        $allCategories->each(function (Category $category) {
            Product::factory(rand(5, 10))->create([
                'category_id' => $category->id,
            ]);
        });

        // Fetch all customer users
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($customers->isNotEmpty() && $products->isNotEmpty()) {
            // Create sample orders for each customer
            foreach ($customers as $customer) {
                // Each customer gets between 1 and 3 orders
                Order::factory(rand(1, 3))->create([
                    'user_id' => $customer->id,
                ])->each(function (Order $order) use ($products) {
                    // For each order, add between 1 and 5 order items
                    $randomProducts = $products->random(min(rand(1, 5), $products->count()));
                    foreach ($randomProducts as $product) {
                        OrderItem::factory()->create([
                            'order_id'   => $order->id,
                            'product_id' => $product->id,
                            // The factory should set quantity and capture the correct product price at the time of order
                        ]);
                    }
                });
            }
        } else {
            $this->command->info('Skipping order creation as no customers or products found.');
        }
    }
}
