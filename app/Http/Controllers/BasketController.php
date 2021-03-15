<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basket;
use App\Product;
use App\Size;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    private function logM($var)
    {
        file_put_contents('D:\logs.txt', "\n".$var."\r\n", FILE_APPEND);
    }
    
    public function index(Request $request)
    {
        // $request->session()->forget('tmpbasket');
        //dd($request->session()->get('tmpbasket'));
        if (Auth::check()) {

            $products = Basket::with([
                'products', 'sizes', 'products.metals',
                'products.categories', 'products.sizes', 'products.stone_colors'
            ])
                ->where('user_id', Auth::id())
                ->get();

            return view('basket.index', compact('products'));
        } elseif ($request->session()->has('tmpbasket')) {

            $products = $request->session()->get('tmpbasket');

            return view('basket.index', compact('products'));
        }

        return view('basket.index', ['products' => []]);
    }
    public function store(Request $request)
    {

        if (Auth::check() && $request->has('vendorCode') && $request->has('count')) {

            if (Basket::where('user_id', Auth::id())
                ->where('product_vendorCode', $request->get('vendorCode'))
                ->where('size_id', $request->get('size_id'))->exists()
            ) {
                Basket::where('user_id', Auth::id())
                    ->where('product_vendorCode', $request->get('vendorCode'))
                    ->where('size_id', $request->get('size_id'))
                    ->increment('count', $request->get('count'));
            } else {
                Basket::firstOrCreate([
                    'user_id' => Auth::id(),
                    'product_vendorCode' => $request->get('vendorCode'),
                    'size_id' => $request->get('size_id') ?? null,
                    'count' => $request->get('count')
                ]);
            }
        } elseif ($request->has('vendorCode') && $request->has('count')) {
            //добавление товара в сессию
            if ($request->session()->has('tmpbasket')) {

                $prods = $request->session()->get('tmpbasket');
                $is_add = false;
                $index = -1;
                foreach ($prods as $key => $prod) {
                    if (
                        $prod['product'] == Product::with(['categories'])->find($request->get('vendorCode'))
                        && $prod['size'] == Size::find($request->get('size_id'))->size ?? 'null'
                    ) {
                        //$prod['count'] += $request->get('count');
                        $is_add = true;
                        $index = $key;
                        break;
                    }
                }

                if (!$is_add) {
                    array_push(
                        $prods,
                        [
                            'product' => Product::with(['categories'])->find($request->get('vendorCode')),
                            'size' => Size::find($request->get('size_id'))->size ?? 'null',
                            'count' => $request->get('count')
                        ]
                    );
                } else $prods[$index]['count'] += $request->get('count');

                $request->session()->put('tmpbasket', $prods);
            } else {

                $request->session()->put(
                    'tmpbasket',
                    [[
                        'product' => Product::with(['categories'])->find($request->get('vendorCode')),
                        'size' => Size::find($request->get('size_id'))->size ?? 'null',
                        'count' => $request->get('count')
                    ]]
                );
            }
        }
        return response()->json(['Product has added']);
        $url = curl_init();
        curl_setopt_array();
    }
    public function delete(Request $request)
    {
        // $this->logM("in delete\n");

        if (Auth::check() && $request->has('vendorCode') && $request->has('count')) {

            /* $this->logM($request->get('vendorCode'));
            $this->logM("Auth::id()");
            $this->logM(Size::where('size', $request->get('size'))->get(['id'])->first()->id ?? null); */
            
            Basket::where('product_vendorCode', '=', $request->get('vendorCode'))
                ->where('user_id', '=', Auth::id())
                ->where('size_id', '=', Size::where('size', $request->get('size'))->get(['id'])->first()->id ?? null)
                ->delete();

            // file_put_contents('D:\logs.txt', "in auth\n");

        } elseif ($request->has('vendorCode') && $request->session()->has('tmpbasket') && $request->has('count')) {

            $this->logM('in delete without auth');

            $prods = $request->session()->get('tmpbasket');

            unset($prods[array_search([
                'product' => Product::with(['categories'])->find($request->get('vendorCode')),
                'size' => $request->get('size') ?? 'null',
                'count' => $request->get('count')
            ], $prods)]);

            $request->session()->put('tmpbasket', $prods);
        }
        return response()->json(['Product has deleted']);
    }

}
