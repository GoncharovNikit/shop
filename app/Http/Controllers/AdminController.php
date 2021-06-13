<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Metal;
use App\StoneColor;
use App\Size;
use App\ProductSize;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpKernel\Exception\HttpException as ExceptionHttpException;

class AdminController extends Controller
{
    public function check()
    {
        $passw = request('passw', 'def');
        $login = request('login', 'def');

        if ($passw == "admin123" && $login == "admin")
        {
            $products = Product::with(['categories', 'metals', 'stone_colors', 'sizes'])->orderByDesc('created_at')->get();
            $metals = Metal::all();
            $colors = StoneColor::all();
            $sizes = Size::all();
            array_reverse((array)$products);
            return view('admin.index', compact('products', 'metals', 'colors', 'sizes'));
        }
        return redirect()->back();        
    }

    public function mobile()
    {
        $phone = request('phone', 'error phone!');
        return redirect()->back();
    }
  
    public function store(Request $request)
    {
        $this->validate($request, [
            'vendorCode' => 'required|min:3|max:15',
            'description' => 'required|max:150'
        ]);

        $product = new Product();

        $product->vendorCode = request('vendorCode');
        $product->price = request('price');
        $product->description = request('description');
        $product->metal_id = request('metal');
        $product->stoneColor_id = request('color');
        $product->category_id = request('category');
        $product->save();

        if ($product->category_id == 1 || $product->category_id == 7) {
            foreach (request('size') as $size) {
                $sizeProd = new ProductSize();
                $sizeProd->product_vendorCode = request('vendorCode');
                $sizeProd->size_id = $size;
                $sizeProd->save();
            }
        }
        
        return redirect()->back();
    }
    public function delete($id)
    {
        Product::find($id)->delete();
        return redirect()->back();
    }
}
