@extends('admin.layouts.template')
@section('content')

<table class="table table-hover" style="border: 2px solid black;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">ФИО заказчика</th>
            <th scope="col">Номер телефона</th>
            <th scope="col">Сумма</th>
            <th scope="col">Оплата</th>
            <th scope="col">Доставка</th>
            <th scope="col">Примечания</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Товары</th>
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        @foreach($orders as $order)
        <tr>
            <th scope="row">{{$counter}}</th>
            <td>{{$order->fullname}}</td>
            <td>{{$order->phone}}</td>
            <td>{{$order->total_price}}</td>
            <td>{{$order->payment_type->name}}</td>
            <td>{{$order->delivery_type->name}}</td>
            <td>{{$order->remarks}}</td>
            <td>{{$order->created_at}}</td>
            <td>
                <a class="simple-link" href="{{ route('admin.order-details', ['id' => $order->id]) }}">Подробнее</a>
            </td>
        </tr>
        <?php $counter += 1; ?>
        @endforeach
    </tbody>
</table>

@endsection