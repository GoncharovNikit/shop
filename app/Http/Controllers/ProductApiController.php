<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductApiController extends Controller
{
    public function index_by_categories(Request $request, $id)
    {
        return json_encode(Product::with(['categories', 'metals', 'sizes'])
        ->where('products.category_id', $id)
        ->get());
    }
}
