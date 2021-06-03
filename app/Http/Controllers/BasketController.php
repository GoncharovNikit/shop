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
        $products = $request->session()->get('tmpbasket') ?? [];
        
        return view('basket.index', compact('products'));
    }
    public function store(Request $request)
    {
        if ($request->has('vendorCode') && $request->has('count')) {
            //добавление товара в сессию
            $this->logM('adding');
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
    }
    public function delete(Request $request)
    {
        if ($request->has('vendorCode') && $request->session()->has('tmpbasket') && $request->has('count')) {

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
