<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'total_price' => 3820,
            'fullname' => 'Goncharov Nikita Vladimirovich',
            'phone' => '+380(99)635-04-57',
            'payment_type_id' => 1,
            'delivery_type_id' => 1,
            'delivery_data' => 'Omsk | Kiyv',
            'remarks' => 'want it',
        ]);

        DB::table('product_orders')->insert([
            'product_id' => 5,
            'order_id' => 1,
            'product_count' => 3,
            'size' => '14.3'
        ]);
    }
}
