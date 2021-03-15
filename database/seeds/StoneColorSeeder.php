<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoneColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stone_colors')->insert(['name' => 'Синий']);
        DB::table('stone_colors')->insert(['name' => 'Бирюзовый']);
        DB::table('stone_colors')->insert(['name' => 'Зеленый']);
        DB::table('stone_colors')->insert(['name' => 'Белый']);
        DB::table('stone_colors')->insert(['name' => 'Черный']);
        DB::table('stone_colors')->insert(['name' => 'Красный']);
        DB::table('stone_colors')->insert(['name' => 'Коричневый']);
        DB::table('stone_colors')->insert(['name' => 'Голубой']);
    }
}
