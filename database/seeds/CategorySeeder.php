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
        $dirs = array_diff(scandir(public_path('images/catalog/')), array('..', '.'));

        foreach ($dirs as $category) {
            $name_rus = str_replace('_', ' ', substr($category, 0, strpos($category, '.')));
            $name = str_replace('_', ' ', substr($category, strpos($category, '.') + 1));
            DB::table('categories')->insert(['name_rus' => "{$name_rus}", 'name' => "{$name}", 'folder_name' => "{$category}"]);
        }
    }
}
