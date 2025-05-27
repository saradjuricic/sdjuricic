<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $order = Order::create([
                'user_id' => 1,
                'total' => rand(20, 100),
                'status' => 'delivered'
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => rand(1, 5),
                'quantity' => rand(1, 3),
                'price' => rand(15, 50)
            ]);
        }
    }
}
