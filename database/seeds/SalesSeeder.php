<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sales')->insert([ 'product_id' => 4, 'discount' => 30 ]);
        DB::table('sales')->insert([ 'product_id' => 17, 'discount' => 23 ]);
        DB::table('sales')->insert([ 'product_id' => 31, 'discount' => 41.50 ]);
        DB::table('sales')->insert([ 'product_id' => 202, 'discount' => 67 ]);

        DB::table('sale_sizes')->insert([ 'sale_id' => 3, 'size_id' => 3]);
        DB::table('sale_sizes')->insert([ 'sale_id' => 3, 'size_id' => 4]);
        DB::table('sale_sizes')->insert([ 'sale_id' => 3, 'size_id' => 5]);
        DB::table('sale_sizes')->insert([ 'sale_id' => 3, 'size_id' => 6]);
        DB::table('sale_sizes')->insert([ 'sale_id' => 3, 'size_id' => 7]);
        DB::table('sale_sizes')->insert([ 'sale_id' => 3, 'size_id' => 8]);
        DB::table('sale_sizes')->insert([ 'sale_id' => 1, 'size_id' => 4]);
        DB::table('sale_sizes')->insert([ 'sale_id' => 1, 'size_id' => 6]);
    }
}
