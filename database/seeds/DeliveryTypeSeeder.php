<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_types')->insert(['name' => 'НП']);
        DB::table('delivery_types')->insert(['name' => 'УП']);
    }
}
