@extends('admin.layouts.template')
@section('content')
<h1>Подробности к заказу №{{ $order->id }} клиента {{ $order->fullname }}</h1>
<table class="table table-hover" style="border: 2px solid black; padding-left: 40px;">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">#</th>
            <th scope="col">Артикул</th>
            <th scope="col">Цена</th>
            <th scope="col">Категория</th>
            <th scope="col">Количество</th>
            <th scope="col">Размер</th>
            <th scope="col">Сумма за товар</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Страница товара</th>
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        @foreach($order->products as $product)
        <tr>
            <td></td>
            <th scope="row">{{$counter}}</th>
            <td>{{$product->vendorCode}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->categories->name_rus}}</td>
            <td>{{$product->pivot->product_count}}</td>
            <td>{{$product->pivot->size}}</td>
            <td>{{$product->price * $product->pivot->product_count}}</td>
            <td>{{$product->created_at}}</td>
            <td>
                <a class="simple-link" href="{{ route('admin.edit', ['id' => $product->vendorCode]) }}">Просмотреть</a>
            </td>
        </tr>
        <?php $counter += 1; ?>
        @endforeach
    </tbody>
</table>
@endsection