<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function form(Request $request)
    {
        if(!$request->has('amount') || $request->get('amount') <= 0)return redirect()->back();
        $amount = $request->get('amount');
        
        return view('payment.payment-form', compact('amount'));
    }
    public function store(Request $request)
    {
        $request->validate([

        ]);
        dd('storing the order...');
    }
}
