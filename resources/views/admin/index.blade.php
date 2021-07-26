@extends('admin.layouts.template')
@section('content')
<div class="menu">
    <a href="{{ route('admin.orders') }}" class="simple-link">Заказы</a>
    <a href="{{ route('admin.sales') }}" class="simple-link">Распродажи</a>
    <a href="{{ route('admin.slider') }}" class="simple-link">Главный слайдер</a>
</div>
<form action="/admin" method="POST" class="main-form">
    <div class="mb-5">
        <label for="vendorCodeInput" class="form-label">Артикул</label>
        <input name="vendorCode" type="text" class="form-control" id="vendorCodeInput" autocomplete="off" value="{{ old('vendorCode') }}">
    </div>
    <div class="mb-5">
        <label for="priceInput" class="form-label">Цена</label>
        <input name="price" type="number" min="1" max="10000" step="0.01" class="form-control" id="priceInput" value="{{ old('price') }}">
    </div>
    <div class="mb-5">
        <label for="descriptionInput">Описание</label>
        <div class="form-floating">
            <textarea name="description" class="form-control" placeholder="Description" id="descriptionInput" style="height: 100px" value="{{ old('description') }}"></textarea>
        </div>
    </div>
    <div class="mb-5">
        <label for="selectMetal">Метал</label>
        <select name="metal" class="form-select" id="selectMetal" value="{{ old('metal') }}">
            @foreach($metals as $metal)
            <option value="{{$metal->id}}">{{$metal->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-5">
        <label for="selectColor">Цвет камня</label>
        <select name="color" class="form-select" id="selectColor" value="{{ old('color') }}">
            @foreach($colors as $color)
            <option value="{{$color->id}}">{{$color->name}}</option>
            @endforeach
            <option value="null">Без камня</option>
        </select>
    </div>
    <div class="mb-5">
        <label for="selectCategory">Категория</label>
        <select name="category" class="form-select" id="selectCategory" value="{{ old('category') }}">
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name_rus}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-5">

        <label for="selectSize">Размер</label>
        <div name="size" id="selectSize">
            @foreach($sizes as $size)
            <div>
                <input id="cb_size_{{ $size->id }}" name="size[{{$size->id}}]" class="sizeCheck" type="checkbox" checked value="{{$size->id}}">
                <label for="cb_size_{{ $size->id }}">&nbsp;&nbsp;{{$size->size}}</label>
            </div> <br>
            @endforeach
        </div>
    </div>
    @csrf

    <button type="submit" class="btn btn-success">Создать</button>
</form>

<h3 style="padding-left: 20px; margin-bottom: 20px;">Товаров всего: {{ count($products) }}</h3>

<h2 style="padding-left: 20px;">Таблица товаров:</h2>

<table class="table table-hover" style="border: 2px solid black;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Артикул</th>
            <th scope="col">Цена</th>
            <th scope="col">Описание</th>
            <th scope="col">Метал</th>
            <th scope="col">Цвет камня</th>
            <th scope="col">Категория</th>
            <th scope="col">Дата создания</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        @foreach($products as $product)
        <tr>
            <th scope="row">{{$counter}}</th>
            <td>{{$product->vendorCode}}</td>
            <td>{{$product->price}}</td>
            <td>{{mb_substr($product->description, 0, 32).'...'}}</td>
            <td>{{$product->metals->name}}</td>
            <td>{{$product->stone_colors->name}}</td>
            <td>{{$product->categories->name_rus}}</td>
            <td>{{$product->created_at}}</td>
            <td>
                <form style="background: none;" action="{{ route('admin.edit', ['id' => $product->vendorCode]) }}" method="GET">
                    <button type="submit">Изменить</button>
                </form>
            </td>
            <td>
                <form style="background: none;" action="{{ route('admin.delete', ['id' => $product->vendorCode]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
        <?php $counter += 1; ?>
        @endforeach
    </tbody>
</table>
@endsection