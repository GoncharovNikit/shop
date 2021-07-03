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