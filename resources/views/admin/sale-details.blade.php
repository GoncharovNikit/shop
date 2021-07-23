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
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        <tr>
            <td>{{$sale->product->vendorCode}}</td>
            <td class="product-price">{{$sale->product->price}}</td>
            <td class="discount-td-handler">{{$sale->discount}}</td>
            <td class="discount-price">{{round($sale->product->price - ($sale->product->price * $sale->discount / 100), 2)}}</td>
            <td>
                <form action="{{ route('admin.sale-remove', ['id' => $sale->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="simple-link" type="submit">Удалить распродажу</button>
                </form>
            </td>
            <td>
                <a class="simple-link" href="{{ route('admin.edit', ['id' => $sale->product->vendorCode]) }}">Страница товара</a>
            </td>
        </tr>
        <?php $counter += 1; ?>
    </tbody>
</table>
<br><br>
<div class="sizes-wrapper">
    <form action="{{route('admin.sale.edit', ['id' => $sale->id])}}" method="POST" class="main-form">
        @csrf
        @method('PUT')
        <input type="text" value="on" id="is-sale" hidden>
        <h3 style="padding-left: 1.2em;">Скидка, %</h3>
        <input class="discount-inp" type="number" value="{{$sale->discount}}" step="0.01" min="0.01" max="99.99" name="discount" style="padding-left:0.5em; width: 30%;" required>

        <br><br>
        <h3 style="padding-left: 1.2em;">Размеры, учавствующие в распродаже</h3>
        <br>
        <div class="size-sale-btn-wrapper">
            <button type="button" class="size-sale-btn check-all simple-link">Выбрать всё</button>
            <button type="button" class="size-sale-btn decheck-all simple-link">Отменить всё</button>
        </div>
        <br>
        <div name="size" id="selectSize">
            @foreach($sale->product->sizes as $size)
            <div>
                <input id="cb_size_{{ $size->id }}" name="size[{{$size->id}}]" class="sizeCheck" type="checkbox" <?= in_array($size->size, array_column($sale->sizes->toArray(), 'size')) ? 'checked' : ''; ?> value="{{$size->id}}">
                <label for="cb_size_{{ $size->id }}">&nbsp;&nbsp;{{$size->size}}</label>
            </div>
            <br>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
</div>
@endsection