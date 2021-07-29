<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basket;
use App\Product;
use App\Size;
use Illuminate\Support\Facades\Auth;
use App\Services\BasketService;

class BasketController extends Controller
{

    public function index(Request $request)
    {
        $products = $request->session()->get('tmpbasket') ?? [];
        $images = \App\Services\ProductImageService::loadBasketImages(array_column($products, 'product'));
        return view('basket.index', compact('products', 'images'));
    }

    public function store(Request $request)
    {
        if ($request->session()->has('tmpbasket')) $request->session()->put('tmpbasket', BasketService::storeProduct($request));
        else {
            $request->session()->put(
                'tmpbasket',
                BasketService::startBasket($request)
            );
        }
        return response()->json(['count' => $request->has('count') ? $request->get('count') : 0]);
    }

    public function delete(Request $request)
    {
        if ($request->has('vendorCode') && $request->session()->has('tmpbasket') && $request->has('count')) {
            $request->session()->put('tmpbasket', BasketService::removeProduct($request));
            return response()->json(['count' => $request->has('count') ? $request->get('count') : 0]);
        }
        return response()->json(['Leck of information!']);
    }
}
