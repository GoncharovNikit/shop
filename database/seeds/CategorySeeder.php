<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(['name' => 'Кольца']);
        DB::table('categories')->insert(['name' => 'Серьги']);
        DB::table('categories')->insert(['name' => 'Подвесы']);
        DB::table('categories')->insert(['name' => 'Кресты']);
        DB::table('categories')->insert(['name' => 'Цепи']);
        DB::table('categories')->insert(['name' => 'Пусеты']);
        DB::table('categories')->insert(['name' => 'Браслеты']);
    }
}
