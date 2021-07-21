<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use App\Metal;
use App\StoneColor;
use App\Size;
use App\ProductSize;
use App\Http\Requests\ProductRequest;
use App\Services\TelegramService as TG;
use App\Order;
use App\ProductOrder;
use Exception;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpKernel\Exception\HttpException as ExceptionHttpException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

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
        $product->images = Images::loadImages($id) ?? [];
        // dd($product->images);
        return view('admin.edit', compact('product', 'metals', 'colors', 'sizes'));
    }

    public function mobile()
    {
        $phone = request('phone', 'error phone!');
        TG::sendTgMessage("Перезвоните мне пожалуйста: \n$phone");
        
        return redirect()->back();
    }

    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->vendorCode = $request->get('vendorCode');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->metal_id = $request->get('metal');
        $product->stoneColor_id = $request->get('color');
        $product->category_id = $request->get('category');
        $isSaved = $product->save();

        if ($isSaved) {
            Images::createProductImageFolder($request->get('vendorCode'));
            if ($product->category_id == Category::firstWhere('name_rus', 'Кольца')->id || $product->category_id == Category::firstWhere('name_rus', 'Браслеты')->id) {
                foreach ($request->get('size') as $size) {
                    $sizeProd = new ProductSize();
                    $sizeProd->product_id = $product->id;
                    $sizeProd->size_id = $size;
                    $sizeProd->save();
                }
            }
        }
        return redirect()->route('admin.main');
    }

    public function save(ProductRequest $request)
    {
        $this->validate($request, ['old-vendor-code' => 'required|min:4|max:12', 'old-category' => 'required']);

        if ($request->get('vendorCode') != $request->get('old-vendor-code')) 
            Images::renameImageFolder($request->get('old-vendor-code'), $request->get('vendorCode'));

        ProductSize::where('product_id', Product::firstWhere('vendorCode', $request->get('old-vendor-code'))->id)->delete();

        Product::firstWhere('vendorCode', $request->get('old-vendor-code'))->update([
            'vendorCode' => $request->get('vendorCode'),
            'price' => $request->get('price'),
            'description' => $request->get('description'),
            'metal_id' => $request->get('metal'),
            'stoneColor_id' => $request->get('color'),
            'category_id' => $request->get('category'),
        ]);

        if ($request->get('old-category') != $request->get('category')) 
            Images::changeProductCategoryFolder(Category::find($request->get('old-category'))->folder_name, 
            Category::find($request->get('category'))->folder_name, $request->get('vendorCode'));

        if (
            $request->get('category') == Category::firstWhere('name_rus', 'Кольца')->id ||
            $request->get('category') == Category::firstWhere('name_rus', 'Браслеты')->id
        ) {
            foreach ($request->get('size') as $size) {
                $sizeProd = new ProductSize();
                $sizeProd->product_id = Product::firstWhere('vendorCode', $request->get('vendorCode'))->id;
                $sizeProd->size_id = $size;
                $sizeProd->save();
            }
        }
        
        if ($request->has('btn-del')) Images::deleteImage($request->get('vendorCode'), $request->get('btn-del'));

        if ($request->has('productimages') && !$request->has('btn-del')) Images::changeImageSequence($request->get('vendorCode'), $request->get('productimages'));

        if ($request->hasFile('images'))
            foreach ($request->file('images') as $img)
                Images::storeImage($request->get('vendorCode'), $img);      

        return redirect()->route('admin.edit', ['id' => $request->get('vendorCode')]);
    }

    public function delete($id)
    {
        $prod = Product::with('categories')->firstWhere('vendorCode', $id);

        Images::clearProductImages($prod->vendorCode);
        $prod->delete();
        return redirect()->route('admin.main');
    }

    public function orders() {
        $orders = Order::with(['payment_type', 'delivery_type'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function order_details($id) {
        $order = Order::with(['products', 'size'])->findOrFail($id);
        // dd($order);
        return view('admin.order-details', compact('order'));
    }
    
}
