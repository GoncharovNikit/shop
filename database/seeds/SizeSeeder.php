<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 13; $i<=22.5; $i+=0.5)DB::table('sizes')->insert(['size' => $i]);
    }
}
