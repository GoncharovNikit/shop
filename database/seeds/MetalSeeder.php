<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metals')->insert(['name' => 'Серебро']);
        DB::table('metals')->insert(['name' => 'Золото']);
    }
}
