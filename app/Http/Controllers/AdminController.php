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
use App\Sale;
use Exception;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;
use Symfony\Component\HttpKernel\Exception\HttpException as ExceptionHttpException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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
        $product = Product::with(['categories', 'metals', 'stone_colors', 'sizes', 'sale'])->withCount('sale')->firstWhere('vendorCode', $id);
        $metals = Metal::all();
        $colors = StoneColor::all();
        $sizes = Size::all();
        $product->images = Images::loadImages($id) ?? [];
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
            foreach ($request->get('size', []) as $size) {
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
        $order = Order::with(['products'])->findOrFail($id);
        return view('admin.order-details', compact('order'));
    }

    public function sales() {
        $sales = Sale::with(['product'])->withCount('sizes')->get();
        return view('admin.sales', compact('sales'));
    }
    
    public function sale_details($id) {
        $sale = Sale::with(['product.sizes', 'sizes'])->findOrFail($id);
        return view('admin.sale-details', compact('sale'));
    }
    
    public function sale_remove($id) {
        Sale::findOrFail($id)->delete();
        return redirect()->route('admin.sales')->withSuccess('Удалено успешно!');
    }

    public function sale_edit(Request $request, $id) {
        $request->validate([ 'discount' => 'required|min:0.01|max:99.99' ]);

        Sale::findOrFail($id)->update(['discount' => $request->get('discount')]);
        DB::table('sale_sizes')->where('sale_id', $id)->delete();
        foreach ($request->get('size', []) as $size) 
            DB::table('sale_sizes')->insert(['sale_id' => $id, 'size_id' => $size ]);
        return redirect()->route('admin.sale-details', ['id' => $id]);
    }

    public function sale_create(Product $product) {
        $product->load(['sizes']);
        return view('admin.sale-create', compact('product'));
    }

    public function sale_store(Request $request) {
        $request->validate(['product_id' => 'required', 'discount' => 'required|min:0.01|max:99.99']);
        $product = Product::with('categories')->findOrFail($request->get('product_id'));
        if ($product->categories->name_rus == 'Кольца' || $product->categories->name_rus == 'Браслеты')
            $request->validate(['size' => 'required']);
        $sale = Sale::create(['product_id' => $request->get('product_id'), 'discount' => $request->get('discount')]);
        if ($product->categories->name_rus == 'Кольца' || $product->categories->name_rus == 'Браслеты')
            foreach ($request->get('size', []) as $size) 
                DB::table('sale_sizes')->insert(['sale_id' => $sale->id, 'size_id' => $size]);
        return redirect()->route('admin.sale-details', ['id' => $sale->id]);
    }

    public function slider() {
        $images = Images::loadMainSliderImages();
        return view('admin.slider', compact('images'));
    }

    public function slider_save(Request $request) {
        if ($request->has('productimages') && !$request->has('btn-del')) Images::changeSliderImageSequence($request->get('productimages'));
        if ($request->has('image_links') && !$request->has('btn-del')) Images::setSliderImageLinks($request->get('image_links'));
        if ($request->has('btn-del')) Images::deleteSliderImage($request->get('btn-del'));

        if ($request->hasFile('images'))
            foreach ($request->file('images') as $img)
                Images::storeSliderImage($img);      

        return redirect()->route('admin.slider', ['id' => $request->get('vendorCode')]);
    }
    
}
