@extends('admin.layouts.template')
@section('content')
@if (!empty($success))
    <h2>{{$success}}</h2>
@endif
<table class="table table-hover" style="border: 2px solid black;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Товар</th>
            <th scope="col">Цена товара<br>без скидки</th>
            <th scope="col">Скидка, %</th>
            <th scope="col">Кол-во размеров<br>(кольца/браслеты)</th>
            <th scope="col">Цена товара<br>со скидкой</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        @foreach($sales as $sale)
        <tr>
            <th scope="row">{{$counter}}</th>
            <td>{{$sale->product->vendorCode}}</td>
            <td>{{$sale->product->price}}</td>
            <td>{{$sale->discount}}</td>
            <td>{{$sale->sizes_count}}</td>
            <td>{{round($sale->product->price - ($sale->product->price * $sale->discount / 100), 2)}}</td>
            <td>
                <a class="simple-link" href="{{ route('admin.sale-details', ['id' => $sale->id]) }}">Подробнее</a>
            </td>
            <td>
                <form action="{{ route('admin.sale-remove', ['id' => $sale->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="simple-link" type="submit">Удалить</button>
                </form>
            </td>
        </tr>
        <?php $counter += 1; ?>
        @endforeach
    </tbody>
</table>

@endsection