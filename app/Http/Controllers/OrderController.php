<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BasketService as Basket;
use App\DeliveryType;
use App\PaymentType;
use App\Order;
use App\Size;
use App\ProductOrder;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (Basket::isEmpty($request)) return redirect()->back();
        $amount = Basket::calcTotalSum($request);
        return view('order.payment-form', compact('amount'));
    }
    public function store(Request $request)
    {
        if (Basket::isEmpty($request)) return redirect()->route('shop.main');

        $request->validate([
            'name' => 'required|min:5|max:90',
            'phone' => 'required|min:9|max:19',
            'payment-radio' => 'required',
            'delivery-radio' => 'required',
        ]);

        if ($request->get('delivery-radio') == 'novaposhta')
            $request->validate([
                'city-np' => 'required',
                'otd-np' => 'required'
            ]);
        else if ($request->get('delivery-radio') == 'ukrposhta')
            $request->validate([
                'city-up' => 'required',
                'otd-up' => 'required'
            ]);


        $order = new Order([
            'total_price' => Basket::calcTotalSum($request),
            'fullname' => $request->get('name'),
            'phone' => $request->get('phone'),
            'payment_type_id' => $request->get('payment-radio') == 'card' ?
                PaymentType::firstWhere('name', 'безналичный')->id :
                PaymentType::firstWhere('name', 'наличный')->id,
            'delivery_type_id' => $request->get('delivery-radio') == 'novaposhta' ?
                DeliveryType::firstWhere('name', 'НП')->id :
                DeliveryType::firstWhere('name', 'УП')->id,
            'delivery_data' => $request->get('delivery-radio') == 'novaposhta' ?
                $request->get('city-np') . ' | ' . $request->get('otd-np') :
                $request->get('city-up') . ' | ' . $request->get('otd-up'),
            'remarks' => $request->get('remarks', 'none') ?? 'none',
        ]);

        $order->save();
        
        $prods = $request->session()->get('tmpbasket');

        foreach ($prods as $prod) {
            $order_prod = new ProductOrder([
                'product_id' => $prod['product']->id,
                'order_id' => $order->id,
                'product_count' => $prod['count'],
                'size_id' => Size::firstWhere('size', $prod['size'])->id ?? null
            ]);
            $order_prod->save();
        }

        $job = new \App\Jobs\AfterOrderConfirmJob($order, $prods);
        $this->dispatchNow($job);
        $request->session()->remove('tmpbasket');

        $request->session()->put('after_order', true);
        return redirect()->route('order.thanks');
    }

    public function thanks(Request $request)
    {
        if ($request->session()->get('after_order', false)) {
            $request->session()->put('after_order', false);
            return view('order.thanks');
        }
        return redirect()->back();
    }
}
