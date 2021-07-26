<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Size;
use App\Sale;
use App\Services\ProductImageService as Images;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function list(Request $request, $category = 'all')
    {
        $maxPrice = Product::max('price');
        $minPrice = Product::min('price');
        $sizes = Size::all();

        $images = Images::loadAllImages(0, 2);
        
        $products = [];
        if ($category == 'all') $products = $products = Product::with(['categories', 'sizes', 'sale.sizes'])->withCount('sale')->get()->shuffle();
        elseif ($category == 'sales') {
            $sales = Sale::with(['product', 'sizes'])->get()->shuffle();
            return view('shop.sales.list', compact('sales', 'maxPrice', 'minPrice', 'sizes', 'images'));
        }
        else {
            $products = Product::with(['categories', 'sale.sizes', 'sizes'])->withCount('sale')
            ->whereHas('categories', function($query) use($category){
                $query->where('name', $category);
            })
            ->get();
        }
        return view('shop.list', compact('products', 'maxPrice', 'minPrice', 'sizes', 'images'));
    }

    public function search()
    {
        $search_str = request()->input('search', 'def');   
        $products = Product::with(['categories', 'sizes'])
            ->where('vendorCode', 'LIKE', "%$search_str%")
            ->get()
            ->shuffle();
        $maxPrice = Product::max('price');
        $minPrice = Product::min('price');
        $sizes = Size::all();

        
        return view('shop.list', compact('products', 'maxPrice', 'minPrice', 'sizes'));
    }

    public function main()
    {
        $slider_images = Images::loadMainSliderImages();
        $bestsellers = DB::select('SELECT product_id, SUM(product_count) as total_count FROM product_orders GROUP BY product_id ORDER BY total_count DESC');
        $bestsellers = array_slice($bestsellers, 0, 12);
        $bestsellers = array_map(function($e) { return Product::with('categories')->findOrFail($e->product_id); }, $bestsellers);
        $images = Images::loadBasketImages($bestsellers);
        return view('shop.main', compact('slider_images', 'bestsellers', 'images'));
    }

    public function single($category, $id)
    {
        $product = Product::with(['categories', 'sizes', 'sale.sizes'])->withCount('sale')->firstWhere('vendorCode', $id);
        $images = Images::loadImages($product->vendorCode);
        if ($product->sale_count > 0) $product->discount_price = $product->price - ($product->price * $product->sale->discount / 100);
        $product->is_sale_page = false;
        return view('shop.single-product', compact('product', 'images'));
    }

    public function single_sale($category, $id)
    {
        $product = Product::with(['categories', 'sale.sizes'])->withCount('sale')->firstWhere('vendorCode', $id);
        $images = Images::loadImages($product->vendorCode);
        $product->discount_price = $product->price - ($product->price * $product->sale->discount / 100);
        $product->is_sale_page = true;
        return view('shop.single-product', compact('product', 'images'));
    }
}
