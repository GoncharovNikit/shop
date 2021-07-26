@extends('admin.layouts.template')
@section('content')
<div class="menu">
    @if ($product->sale_count)
    <a href="{{ route('admin.sale-details', ['id' => $product->sale->id]) }}" class="simple-link">Страница распродажи</a>
    @else
    <a href="{{ route('admin.sale-create', ['product' => $product->id]) }}" class="simple-link">Назначить распродажу</a>
    @endif
</div>
<form class="main-form" action="{{ route('admin.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="text" value="{{ $product->vendorCode }}" name="old-vendor-code" hidden>
    <input type="text" value="{{ $product->categories->id }}" name="old-category" hidden>
    <div class="mb-5">
        <label for="vendorCodeInput" class="form-label">Артикул</label>
        <input name="vendorCode" type="text" class="form-control" id="vendorCodeInput" autocomplete="off" value="{{ old('vendorCode') ?? $product->vendorCode }}">
    </div>
    <div class="mb-5">
        <label for="priceInput" class="form-label">Цена</label>
        <input name="price" type="number" min="1" max="10000" step="0.01" class="form-control" id="priceInput" value="{{ old('price') ?? $product->price }}">
    </div>
    <div class="mb-5">
        <label for="descriptionInput">Описание</label>
        <div class="form-floating">
            <textarea name="description" class="form-control" placeholder="Description" id="descriptionInput" style="height: 100px">{{ old('description') ?? $product->description }}</textarea>
        </div>
    </div>
    <div class="mb-5">
        <label for="selectMetal">Метал</label>
        <select name="metal" class="form-select" id="selectMetal">
            @foreach($metals as $metal)
            <option value="{{$metal->id}}" <?= $product->metals->id == $metal->id ? 'selected' : '' ?>>{{$metal->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-5">
        <label for="selectColor">Цвет камня</label>
        <select name="color" class="form-select" id="selectColor">
            @foreach($colors as $color)
            <option value="{{$color->id}}" <?= $product->stone_colors->id == $color->id ? 'selected' : '' ?>>{{$color->name}}</option>
            @endforeach
            <option value="null">Без камня</option>
        </select>
    </div>
    <div class="mb-5">
        <label for="selectCategory">Категория</label>
        <select name="category" class="form-select" id="selectCategory">
            @foreach($categories as $category)
            <option value="{{$category->id}}" <?= $product->categories->id == $category->id ? 'selected' : '' ?>>{{$category->name_rus}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-5">
        <label for="selectSize">Размер</label>
        <br><br>
        <div class="size-sale-btn-wrapper">
            <button type="button" class="size-sale-btn check-all simple-link">Выбрать всё</button>
            <button type="button" class="size-sale-btn decheck-all simple-link">Отменить всё</button>
        </div>
        <br>
        <div name="size" id="selectSize">
            @foreach($sizes as $size)
            <div>
                <input id="cb_size_{{ $size->id }}" name="size[{{$size->id}}]" class="sizeCheck" type="checkbox" <?= in_array($size->size, array_column($product->sizes->toArray(), 'size')) ? 'checked' : ''; ?> value="{{$size->id}}">

                <label for="cb_size_{{ $size->id }}">&nbsp;&nbsp;{{$size->size}}</label>
            </div>
            <br>
            @endforeach
        </div>
    </div>
    <div class="product-images mb-5">
        <div class="img-add">
            <label for="images">Добавить изображения</label>
            <input id="images" name="images[]" type="file" accept=".jpg, .jpeg, .png" multiple>
            <!-- <button type="submit">Добавить</button> -->
        </div>
        <div id="images-wrapper">
            @forelse ($product->images as $img)
            <div class="prod-img-item">
                <img src="{{ asset('images/catalog/'.$product->categories->folder_name.'/'.$product->vendorCode.'/'.$img) }}" />
                <input type="text" value="{{ $img }}" name="productimages[]" hidden>
                <button type="submit" name="btn-del" value="{{ $img }}" class="btn-del-img"><img src="{{ asset('images/ico-del.png') }}" alt="Удалить"></button>
            </div>
            @empty
            <p>Изображения для данного товара не найдены!</p>
            @endforelse
        </div>
    </div>
    <button type="submit" class="btn btn-success">Сохранить</button>
</form>

@endsection