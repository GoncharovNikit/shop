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
        DB::table('categories')->insert(['name_rus' => 'Кольца', 'name' => 'Rings']);
        DB::table('categories')->insert(['name_rus' => 'Серьги', 'name' => 'Earrings']);
        DB::table('categories')->insert(['name_rus' => 'Подвесы', 'name' => 'Pendant']);
        DB::table('categories')->insert(['name_rus' => 'Кресты', 'name' => 'Crosses']);
        DB::table('categories')->insert(['name_rus' => 'Цепи', 'name' => 'Chains']);
        DB::table('categories')->insert(['name_rus' => 'Пусеты', 'name' => 'Studs']);
        DB::table('categories')->insert(['name_rus' => 'Браслеты', 'name' => 'Bracelets']);
        DB::table('categories')->insert(['name_rus' => 'Подарочные коробки', 'name' => 'Gift boxes']);
    }
}
