<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_types')->insert(['name' => 'наличный']);
        DB::table('payment_types')->insert(['name' => 'безналичный']);
    }
}
