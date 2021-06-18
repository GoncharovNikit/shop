<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Size;
use App\User;
use App\Basket;

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

        $images = [];
        foreach ($products as $prod)
            $images[$prod->vendorCode] = array_diff(scandir(public_path("images/cat/{$prod->categories->name_rus}/{$prod->vendorCode}/")), array('..', '.'));

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
        // dd($products);
        return view('shop.main', compact('products'));
    }

    public function single(Request $request, $category, $id)
    {
        $product = Product::with(['categories', 'sizes'])->findOrFail($id);
        $images = array_diff(scandir(public_path("images/cat/{$product->categories->name_rus}/{$product->vendorCode}/")), array('..', '.'));

        return view('shop.single-product', compact('product', 'images'));
    }

    public function personal(Request $request, $userid)
    {
        if(!(Auth::check() && Auth::id() == $userid))return redirect()->back();
        $user = User::where('id', '=', $userid)->first();
        $basketProdCount = Basket::where('user_id', $userid)->count();
        $ordersCount = 0;//Orders::where('user_id', $userid)->count();
        return view('personal.main', compact('user', 'basketProdCount', 'ordersCount'));
    }
}
