<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Size;
use App\User;
use App\Basket;
use App\Services\ProductImageService as Images;

use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function list(Request $request, $category = 'all')
    {
        $products = [];
        if ($category == 'all') $products = Product::with(['sizes'])->get();
        else {
            $products = Product::with(['categories', 'sizes'])
            ->whereHas('categories', function($query) use($category){
                $query->where('name', $category);
            })
            ->get();
        }
        $maxPrice = Product::max('price');
        $minPrice = Product::min('price');
        $sizes = Size::all();

        $images = Images::loadAllImages(0, 2);
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
        $products = Product::with('categories')->orderBy('created_at')->take(10)->get();
        return view('shop.main', compact('products'));
    }

    public function single(Request $request, $category, $id)
    {
        $product = Product::with(['categories', 'sizes'])->firstWhere('vendorCode', $id);
        $images = Images::loadImages($product->vendorCode);

        return view('shop.single-product', compact('product', 'images'));
    }

}
