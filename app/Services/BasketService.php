<?php

namespace App\Services;

use App\Product;
use App\Size;

class BasketService
{
    public static function isEmpty($request)
    {
        return count($request->session()->get('tmpbasket', []) ?? []) == 0;
    }
    public static function startBasket($request)
    {
        return [[
            'product' => Product::with(['categories'])->firstWhere('vendorCode', $request->get('vendorCode')),
            'size' => Size::find($request->get('size_id'))->size ?? 'null',
            'count' => $request->get('count')
        ]];
    }
    public static function productCount()
    {
        if (self::isEmpty(request())) return 0;
        $prods = request()->session()->get('tmpbasket');
        return array_reduce($prods, function($total, $item) {
            $total += $item['count'];
            return $total;
        }, 0);
    }
    public static function storeProduct($request)
    {
        $prods = $request->session()->get('tmpbasket');
        if (!$request->has('vendorCode') || !$request->has('count')) return $prods;
        $product = Product::with(['categories'])->firstWhere('vendorCode', $request->get('vendorCode'));
        if (($product->categories->name_rus == 'Кольца' || $product->categories->name_rus == 'Браслеты') && !$request->has('size_id')) return $prods;

        foreach ($prods as $key => $prod) {
            if ($prod['product'] == $product) {
                if ($product->categories->name_rus == 'Кольца' || $product->categories->name_rus == 'Браслеты') {
                    if ($prod['size'] == Size::find($request->get('size_id'))->size) {
                        $prods[$key]['count'] += $request->get('count');
                        return $prods;
                    }
                } else {
                    $prods[$key]['count'] += $request->get('count');
                    return $prods;
                }
            }
        }
        array_push(
            $prods,
            [
                'product' => Product::with(['categories'])->firstWhere('vendorCode', $request->get('vendorCode')),
                'size' => Size::find($request->get('size_id'))->size ?? 'null',
                'count' => $request->get('count')
            ]
        );

        return $prods;
    }
    public static function removeProduct($request)
    {
        $prods = $request->session()->get('tmpbasket');

        unset($prods[array_search([
            'product' => Product::with(['categories'])->firstWhere('vendorCode', $request->get('vendorCode')),
            'size' => $request->get('size') ?? 'null',
            'count' => $request->get('count')
        ], $prods)]);

        return $prods;
    }
    public static function calcTotalSum($request)
    {
        $prods = $request->session()->get('tmpbasket') ?? [];
        $sum = 0;
        foreach ($prods as $prod)
            $sum += $prod['product']->price * $prod['count'];
        return $sum;
    }
}
