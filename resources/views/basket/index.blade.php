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
            <?php $tmp = clone $item['product']; $tmp->load('sale'); ?>
            <tr class="cart-tr">
                <td class="items">
                    <div class="cart-image sale-img-relative">
                        @if (count($images[$item['product']->vendorCode]) > 0)
                        <img src="{{asset('images/catalog/'.$item['product']->categories->folder_name.'/'.$item['product']->vendorCode.'/'.$images[$item['product']->vendorCode][0])}}" alt="productImage">
                        @endif
                        @if (!(($tmp->sale == null || (($tmp->categories->name_rus == 'Кольца' || $tmp->categories->name_rus == 'Браслеты') && !in_array($item['size'], array_column($tmp->sale->sizes->toArray(), 'size'))))))
                        <img src="{{ asset('images/sale.png') }}" class="sale-basket-img" alt="sale">
                        @endif
                    </div>
                    <h3><a href="#">Lorem ipsum dolor</a></h3>
                    <p>
                        {{$item['product']->description}}
                    </p>
                </td>
                @if (($tmp->sale == null || (($tmp->categories->name_rus == 'Кольца' || $tmp->categories->name_rus == 'Браслеты') && !in_array($item['size'], array_column($tmp->sale->sizes->toArray(), 'size')))))
                <td class="price basket-td">&#8372; {{round($item['product']->price)}}</td>
                @else
                <td class="price basket-td">&#8372; {{round($tmp->price - ($tmp->price * $tmp->sale->discount / 100))}}</td>
                @endif
                <td class="qnt basket-td" data-singleprice="{{round($item['product']->price)}}">{{$item['count']}}</td>
                <td class="size basket-td">{{$item['size'] == 'null'?'':$item['size']}}</td>
                @if (($tmp->sale == null || (($tmp->categories->name_rus == 'Кольца' || $tmp->categories->name_rus == 'Браслеты') && !in_array($item['size'], array_column($tmp->sale->sizes->toArray(), 'size')))))
                <td class="total-price-p basket-td" data-total="{{round($item['count'] * $item['product']->price)}}">$ {{round($item['count'] * $item['product']->price)}}</td>
                @else
                <td class="total-price-p basket-td" data-total="{{round($item['count'] * ($tmp->price - ($tmp->price * $tmp->sale->discount / 100)))}}">$ {{round($item['count'] * ($tmp->price - ($tmp->price * $tmp->sale->discount / 100)))}}</td>
                @endif
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