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
    public function list(Request $request)
    {
        //$products = Product::with('sizes')->get();
        $products = Product::all();
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

    public function single(Request $request, $id)
    {
        $product = Product::with(['categories', 'sizes'])->findOrFail($id);

        return view('shop.single-product', compact('product'));
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
