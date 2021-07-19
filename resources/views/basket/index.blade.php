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
            
            @forelse($products as $item)
            <tr class="cart-tr">
                <td class="items">
                    <div class="cart-image">
                        @if (count($images[$item['product']->vendorCode]) > 0)
                        <img src="{{asset('images/cat/'.$item['product']->categories->folder_name.'/'.$item['product']->vendorCode.'/'.$images[$item['product']->vendorCode][0])}}" alt="productImage">
                        @endif
                    </div>
                    <h3><a href="#">Lorem ipsum dolor</a></h3>
                    <p>
                        {{$item['product']->description}}
                    </p>
                </td>
                <td class="price basket-td">&#8372; {{$item['product']->price}}</td>
                <td class="qnt basket-td" data-singleprice="{{$item['product']->price}}">{{$item['count']}}</td>
                <td class="size basket-td">{{$item['size'] == 'null'?'':$item['size']}}</td>
                <td class="total-price-p basket-td" data-total="{{$item['count'] * $item['product']->price}}">$ {{$item['count'] * $item['product']->price}}</td>
                <td class="delete basket-td"><a data-vendor="{{$item['product']->vendorCode}}" class="ico-del"></a></td>
            </tr>
            @empty
            <tr>
                <td>
                    Товари не знайдені!
                </td>
            </tr>
            @endforelse

        </table>
    </div>

    <div class="total-count">
        <h3>Всього до сплати: <strong id="totalSum"></strong></h3>
        <form action="{{route('order.form')}}" method="get">
            <input id="totalSum-form" type="number" step="0.01" name="amount" hidden />   
            <button class="btn payment" type="submit">Замовити</button>
        </form>
    </div>

</div>
@endsection