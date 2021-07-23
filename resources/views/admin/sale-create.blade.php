@extends('admin.layouts.template')
@section('content')
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Товар</th>
            <th scope="col">Цена товара<br>без скидки</th>
            <th scope="col">Скидка, %</th>
            <th scope="col">Цена товара<br>со скидкой</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        <tr>
            <td>{{$product->vendorCode}}</td>
            <td class="product-price">{{$product->price}}</td>
            <td class="discount-td-handler">10</td>
            <td class="discount-price">{{round($product->price - ($product->price * 10 / 100), 2)}}</td>
            <td>
                <a class="simple-link" href="{{ route('admin.edit', ['id' => $product->vendorCode]) }}">Страница товара</a>
            </td>
        </tr>
        <?php $counter += 1; ?>
    </tbody>
</table>
<br><br>
<div class="sizes-wrapper">
    <form action="{{route('admin.sale.store')}}" method="POST" class="main-form">
        @csrf
        <input type="text" value="on" id="is-sale" hidden>
        <input type="text" name="product_id" value="{{ $product->id }}" hidden>
        <h3 style="padding-left: 1.2em;">Скидка, %</h3>
        <input class="discount-inp" type="number" value="10" step="0.01" min="0.01" max="99.99" name="discount" style="padding-left:0.5em; width: 30%;" required>
        <br>
        @if ($product->categories->name_rus == 'Кольца' || $product->categories->name_rus == 'Браслеты')
        <br>
        <h3 style="padding-left: 1.2em;">Размеры, учавствующие в распродаже</h3>
        <br>
        <div class="size-sale-btn-wrapper">
            <button type="button" class="size-sale-btn check-all simple-link">Выбрать всё</button>
            <button type="button" class="size-sale-btn decheck-all simple-link">Отменить всё</button>
        </div>
        <br>
        <div name="size" id="selectSize">
            @foreach($product->sizes as $size)
            <div>
                <input id="cb_size_{{ $size->id }}" name="size[{{$size->id}}]" class="sizeCheck" type="checkbox" <?= in_array($size->size, array_column($product->sizes->toArray(), 'size')) ? 'checked' : 'disabled'; ?> value="{{$size->id}}">
                <label for="cb_size_{{ $size->id }}">&nbsp;&nbsp;{{$size->size}}</label>
            </div>
            <br>
            @endforeach
        </div>
        @endif

        <button type="submit" class="btn btn-success">Назначить</button>
    </form>
</div>
@endsection