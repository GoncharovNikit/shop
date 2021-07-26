@extends('admin.layouts.template')
@section('content')
<form class="main-form" action="{{ route('admin.slider.save') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="product-images mb-5">
        <div class="img-add">
            <label for="images">Добавить изображения</label>
            <input id="images" name="images[]" type="file" accept=".jpg, .jpeg, .png" multiple>
        </div>
        <div id="images-wrapper">
            @forelse ($images as $img)
            <div class="prod-img-item">
                <img src="{{ asset('images/main_slider/'.$img['folder'].'/1.'.$img['extension']) }}" />
                <input type="text" value="{{ $img['folder'] }}" name="productimages[]" hidden>
                <button type="submit" name="btn-del" value="{{ $img['folder'] }}" class="btn-del-img"><img src="{{ asset('images/ico-del.png') }}" alt="Удалить"></button>
                <br>
                <input type="text" name="image_links[]" value="{{ $img['link'] }}">
            </div>
            <br><br>
            @empty
            <p>Изображения для слайдера не найдены!</p>
            @endforelse
        </div>
    </div>
    <button type="submit" class="btn btn-success">Сохранить</button>
</form>

@endsection