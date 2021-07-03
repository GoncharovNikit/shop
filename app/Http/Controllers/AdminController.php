<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use App\Metal;
use App\StoneColor;
use App\Size;
use App\ProductSize;
use Exception;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpKernel\Exception\HttpException as ExceptionHttpException;

use App\Services\ProductImageService as Images;

class AdminController extends Controller
{

    public function index()
    {
        $products = Product::with(['categories', 'metals', 'stone_colors', 'sizes'])->orderByDesc('created_at')->get();
        $metals = Metal::all();
        $colors = StoneColor::all();
        $sizes = Size::all();
        array_reverse((array)$products);
        return view('admin.index', compact('products', 'metals', 'colors', 'sizes'));
    }

    public function login(Request $request)
    {
        if ($request->session()->get('IS_ADMIN', 'no') == 'yes')
            return redirect()->route('admin.main');
        return view('admin.auth');
    }

    public function check(Request $request)
    {
        $passw = request('passw', 'def');
        $login = request('login', 'def');

        if ($passw == "admin123" && $login == "admin") {
            $request->session()->put('IS_ADMIN', 'yes');
            return redirect()->route('admin.main');
        }
        return redirect()->route('admin.login');
    }

    public function edit(Request $request, $id)
    {
        $product = Product::with(['categories', 'metals', 'stone_colors', 'sizes'])->firstWhere('vendorCode', $id);
        $metals = Metal::all();
        $colors = StoneColor::all();
        $sizes = Size::all();
        $product->images = Images::loadImages($id);

        return view('admin.edit', compact('product', 'metals', 'colors', 'sizes'));
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
            'description' => 'required|max:150',
            'price' => 'required',
        ]);

        $product = new Product();

        $product->vendorCode = request('vendorCode');
        $product->price = request('price');
        $product->description = request('description');
        $product->metal_id = request('metal');
        $product->stoneColor_id = request('color');
        $product->category_id = request('category');
        $isSaved = $product->save();

        if ($isSaved) {
            Images::createProductImageFolder(request('vendorCode'));
            if ($product->category_id == 1 || $product->category_id == 7) {
                foreach (request('size') as $size) {
                    $sizeProd = new ProductSize();
                    $sizeProd->product_vendorCode = request('vendorCode');
                    $sizeProd->size_id = $size;
                    $sizeProd->save();
                }
            }
        }
        return redirect()->route('admin.main');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'old-vendor-code' => 'required|min:3|max:15',
            'vendorCode' => 'required|min:3|max:15',
            'description' => 'required|max:150',
            'price' => 'required',
            'metal' => 'required',
            'category' => 'required',
        ]);

        if (request('vendorCode') != request('old-vendor-code'))
            Images::renameImageFolder(request('old-vendor-code'), request('vendorCode'));

        ProductSize::where('product_id', Product::firstWhere('vendorCode', request('old-vendor-code'))->id)->delete();

        Product::firstWhere('vendorCode', request('old-vendor-code'))->update([
            'vendorCode' => request('vendorCode'),
            'price' => request('price'),
            'description' => request('description'),
            'metal_id' => request('metal'),
            'stoneColor_id' => request('color'),
            'category_id' => request('category'),
        ]);

        if (request('category') == Category::where('name_rus', 'Кольца')->get('id') || 
            request('category') == Category::where('name_rus', 'Браслеты')->get('id')) {
            foreach (request('size') as $size) {
                $sizeProd = new ProductSize();
                $sizeProd->product_vendorCode = request('vendorCode');
                $sizeProd->size_id = $size;
                $sizeProd->save();
            }
        }


        /*
            Добавить размеры товара в edit вьюхе.
            


        */
        
        

        return redirect()->route('admin.main');
    }

    public function delete($id)
    {
        $prod = Product::with('categories')->firstWhere('vendorCode', $id);

        Images::clearProductImages($prod->vendorCode);
        $prod->delete();
        return redirect()->route('admin.main');
    }
}
