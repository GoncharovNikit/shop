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
        $vendorCodes = Product::select('vendorCode')
        ->where('category_id', '=', '1')
        ->orWhere('category_id', '=', '7')
        ->get();

        $sizes = Size::all();

        foreach ($vendorCodes as $item) {
            foreach ($sizes as $size) {
                DB::table("product_sizes")->insert([
                    "size_id" => $size->id,
                    "product_vendorCode" => $item->vendorCode
                ]);
            }
        }
    }
}
