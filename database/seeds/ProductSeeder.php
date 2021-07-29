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

        $dirs = array_diff(scandir(public_path('images/catalog/')), array('..', '.'));

        foreach ($dirs as $category) {
            $prod_folders = array_diff(scandir(public_path('images/catalog/') . $category), array('..', '.'));
            $name_rus = str_replace('_', ' ', substr($category, 0, strpos($category, '.')));
            $category_id = \App\Category::where('name_rus', "$name_rus")->firstOrFail()->id;

            foreach ($prod_folders as $vendorCode) {
                DB::table('products')->insert([
                    'vendorCode' => $vendorCode,
                    'price' => $faker->randomFloat(2, 10, 5000),
                    'description_ru' => 'Russian :'.$faker->paragraph(3),
                    'description_uk' => 'Ukranian :'.$faker->paragraph(3),
                    'metal_id' => 1,
                    'category_id' => $category_id,
                ]);
            }
        }
    }
}
