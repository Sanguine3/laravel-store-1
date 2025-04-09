<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Ensure a valid user_id exists.
        $userId = User::inRandomOrder()->value('id') ?: 1;

        return [
            'user_id'      => $userId,
            // Assuming orders have an order number and a status.
            'order_number' => $this->faker->unique()->numerify('ORD###'),
            'status'       => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total_amount' => $this->faker->randomFloat(2, 20, 500),
            'created_at'   => $this->faker->dateTime(),
            'updated_at'   => now(),
        ];
    }
}
?>
