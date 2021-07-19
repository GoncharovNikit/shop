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
    public static function storeProduct($request)
    {
        $prods = $request->session()->get('tmpbasket');
        $is_add = false;
        $index = -1;
        foreach ($prods as $key => $prod) {
            if (
                $prod['product'] == Product::with(['categories'])->firstWhere('vendorCode', $request->get('vendorCode'))
                && $prod['size'] == Size::find($request->get('size_id'))->size ?? 'null'
            ) {
                $is_add = true;
                $index = $key;
                break;
            }
        }

        if (!$is_add) {
            array_push(
                $prods,
                [
                    'product' => Product::with(['categories'])->firstWhere('vendorCode', $request->get('vendorCode')),
                    'size' => Size::find($request->get('size_id'))->size ?? 'null',
                    'count' => $request->get('count')
                ]
            );
        } else $prods[$index]['count'] += $request->get('count');

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
