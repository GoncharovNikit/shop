@extends('layouts.template');

@section('content')
<div id="breadcrumbs">
	<div class="container">
		<ul>
			<li><a href="{{route('shop.main')}}">Головна</a></li>
			<li>Кошик</li>
		</ul>
	</div>
	<!-- / container -->
</div>
<div id="content" class="full">
    <div class="cart-table">
        <table>
            <tr>
                <th class="items">Товари</th>
                <th class="price">Ціна</th>
                <th class="qnt">Кількість</th>
                <th class="qnt">Розмір</th>
                <th class="total">Усього</th>
                <th class="delete"></th>
            </tr>
            
            @if(Auth::check())

            @forelse($products as $item)
            <tr class="cart-tr">
                <td class="items">
                    <div class="cart-image">
                        <img 
                        src="{{asset('images/catComp/'.$item->products->categories->name.'/'.$item->products->vendorCode.'.jpg')}}" alt="productImage">
                    </div>
                    <h3><a href="#">Lorem ipsum dolor</a></h3>
                    <p>
                        {{$item->products->description}}
                    </p>
                </td>
                <td class="price"><div>&#8372; {{$item->products->price}}</div></td>
                <td class="qnt"><div><input data-singleprice="{{$item->products->price}}" type="number" name="countinp" class="countinp" value="{{$item->count}}" min="1" max="1000"></div></td>
                <td class="size"><div>{{$item->sizes['size']}}</div></td>
                <td class="total" data-total="{{$item->count * $item->products->price}}"><div>$ {{$item->count * $item->products->price}}</div></td>
                <td class="delete"><div><a data-vendor="{{$item->products->vendorCode}}" class="ico-del"></a></div></td>
            </tr>
            @empty
            <tr>
                Товари не знайдені!
            </tr>
            @endforelse

            @else

            @forelse($products as $item)
            <tr class="cart-tr">
                <td class="items">
                    <div class="cart-image">
                        <img 
                        src="{{asset('images/catComp/'.$item['product']->categories->name.'/'.$item['product']->vendorCode.'.jpg')}}" alt="productImage">
                    </div>
                    <h3><a href="#">Lorem ipsum dolor</a></h3>
                    <p>
                        {{$item['product']->description}}
                    </p>
                </td>
                <td class="price">&#8372; {{$item['product']->price}}</td>
                <td class="qnt"><input data-singleprice="{{$item['product']->price}}" type="number" name="countinp" class="countinp" value="{{$item['count']}}" min="1" max="1000"></td>
                <td class="size">{{$item['size'] == 'null'?'':$item['size']}}</td>
                <td class="total" data-total="{{$item['count'] * $item['product']->price}}">$ {{$item['count'] * $item['product']->price}}</td>
                <td class="delete"><a data-vendor="{{$item['product']->vendorCode}}" class="ico-del"></a></td>
            </tr>
            @empty
            <tr>
                <td>
                    Товари не знайдені!
                </td>
            </tr>
            @endforelse


            @endif
        </table>
    </div>

    <div class="total-count">
        <h3>Всього до сплати: <strong id="totalSum"></strong></h3>
        <form action="{{route('order.form')}}" method="post">
            @csrf
            <input id="totalSum-form" type="number" step="0.01" name="amount" hidden />   
            <button class="btn payment" type="submit">Сплатити</button>
        </form>
    </div>

</div>
@endsection