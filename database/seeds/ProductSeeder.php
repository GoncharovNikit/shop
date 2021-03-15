<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $rings = array_diff(scandir(public_path('images/cat/Кольца/')), array('..', '.'));
        
        $rings = array_map(function($value){
            return substr($value, 0, strrpos($value, '.'));
        }, $rings);

        foreach ($rings as $value) {
            DB::table('products')->insert([
                'vendorCode' => $value,
                'price' => $faker->randomFloat(2, 10, 5000),
                'description' => $faker->paragraph(3),
                'metal_id' => 1,
                'category_id' => 1,
                'stoneColor_id' => 4
            ]);
        }

        $brasleti = array_diff(scandir(public_path('images/cat/Браслеты/')), array('..', '.'));
        $brasleti = array_map(function($value){
            return substr($value, 0, strrpos($value, '.'));
        }, $brasleti);
        
        foreach ($brasleti as $value) {
            DB::table('products')->insert([
                'vendorCode' => $value,
                'price' => $faker->randomFloat(2, 10, 5000),
                'description' => $faker->paragraph(3),
                'metal_id' => 1,
                'category_id' => 7,
                'stoneColor_id' => 4
            ]);
        }

        $kresti = array_diff(scandir(public_path('images/cat/Кресты/')), array('..', '.'));
        $kresti = array_map(function($value){
            return substr($value, 0, strrpos($value, '.'));
        }, $kresti);

        foreach ($kresti as $value) {
            DB::table('products')->insert([
                'vendorCode' => $value,
                'price' => $faker->randomFloat(2, 10, 5000),
                'description' => $faker->paragraph(3),
                'metal_id' => 1,
                'category_id' => 4,
                'stoneColor_id' => 4
            ]);
        }
        
        $podvesi = array_diff(scandir(public_path('images/cat/Подвесы/')), array('..', '.'));
        $podvesi = array_map(function($value){
            return substr($value, 0, strrpos($value, '.'));
        }, $podvesi);

        foreach ($podvesi as $value) {
            DB::table('products')->insert([
                'vendorCode' => $value,
                'price' => $faker->randomFloat(2, 10, 5000),
                'description' => $faker->paragraph(3),
                'metal_id' => 1,
                'category_id' => 3,
                'stoneColor_id' => 4
            ]);
        }

        $puseti = array_diff(scandir(public_path('images/cat/Пусеты/')), array('..', '.'));
        $puseti = array_map(function($value){
            return substr($value, 0, strrpos($value, '.'));
        }, $puseti);

        foreach ($puseti as $value) {
            DB::table('products')->insert([
                'vendorCode' => $value,
                'price' => $faker->randomFloat(2, 10, 5000),
                'description' => $faker->paragraph(3),
                'metal_id' => 1,
                'category_id' => 6,
                'stoneColor_id' => 4
            ]);
        }

        $sergi = array_diff(scandir(public_path('images/cat/Серьги/')), array('..', '.'));
        $sergi = array_map(function($value){
            return substr($value, 0, strrpos($value, '.'));
        }, $sergi);

        foreach ($sergi as $value) {
            DB::table('products')->insert([
                'vendorCode' => $value,
                'price' => $faker->randomFloat(2, 10, 5000),
                'description' => $faker->paragraph(3),
                'metal_id' => 1,
                'category_id' => 2,
                'stoneColor_id' => 4
            ]);
        }
    }
}
