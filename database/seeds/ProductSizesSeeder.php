<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Size;

class ProductSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_ids = Product::select('id')
        ->where('category_id', '=', App\Category::firstWhere('name_rus', 'Браслеты')->id)
        ->orWhere('category_id', '=', App\Category::firstWhere('name_rus', 'Кольца')->id)
        ->get();

        $sizes = Size::all();

        foreach ($product_ids as $item) {
            foreach ($sizes as $size) {
                DB::table("product_sizes")->insert([
                    "size_id" => $size->id,
                    "product_id" => $item->id
                ]);
            }
        }
    }
}
