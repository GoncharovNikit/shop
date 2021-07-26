@extends('layouts.template')
@section('content')

<div id="breadcrumbs">
    <div class="container">
        <ul>
            <li>&nbsp;</li>
        </ul>
    </div>
</div>

<div id="slider">
    <ul>
        @foreach ($slider_images as $img)
        <div>
            <a href="{{ $img['link'] }}">
                <li class="yellow" style="background-image: url({{asset('images/main_slider/'.$img['folder'].'/1.'.$img['extension'])}})">
                </li>
            </a>
        </div>
        @endforeach
    </ul>
</div>


<div class="body">
    <div class="container">
        @if (count($bestsellers) >= 4)
        <div class="bestsellers">
            <h1 class="grid-header">Хиты продаж</h1>
            @foreach ($bestsellers as $product)
            <div class="bestseller-prod-item">
                <a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">
                    <img width="200" src="{{ asset('images/catalog/'.$product->categories->folder_name.'/'.$product->vendorCode.'/'.$images[$product->vendorCode][0]) }}">
                </a>
            </div>
            @endforeach
        </div>
        @endif
        <div class="category-images">
            <h1 class="grid-category-header">Категории товаров</h1>
            <a href="{{ route('shop.list', ['category' => 'Rings']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/ring.png') }}" alt="">
                    <span class="category-img-title">Кольца</span>
                </div>
            </a>
            <a href="{{ route('shop.list', ['category' => 'Earrings']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/earrings.png') }}" alt="">
                    <span class="category-img-title">Серьги</span>
                </div>
            </a>
            <a href="{{ route('shop.list', ['category' => 'Bracelets']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/bracelet.png') }}" alt="">
                    <span class="category-img-title">Браслеты</span>
                </div>
            </a>
            <a href="{{ route('shop.list', ['category' => 'Chains']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/chain.png') }}" alt="">
                    <span class="category-img-title">Цепи</span>
                </div>
            </a>
            <a href="{{ route('shop.list', ['category' => 'Crosses']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/crosses.png') }}" alt="">
                    <span class="category-img-title">Кресты</span>
                </div>
            </a>
            <a href="{{ route('shop.list', ['category' => 'Pendant']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/pendant.png') }}" alt="">
                    <span class="category-img-title">Подвесы</span>
                </div>
            </a>
            <a href="{{ route('shop.list', ['category' => 'Studs']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/studs.png') }}" alt="">
                    <span class="category-img-title">Пусеты</span>
                </div>
            </a>
            <a href="{{ route('shop.list', ['category' => 'Gift boxes']) }}">
                <div class="category-img-item">
                    <img src="{{ asset('images/category-images/boxes.png') }}" alt="">
                    <span class="category-img-title">Футляры</span>
                </div>
            </a>
        </div>
        <div id="about-wrap">
            <h1 class="about-header">AVANGARD</h1>
            <div id="about-text">
                @lang('messages.about')
            </div>
        </div>
        <div class="facts">
            <h1 class="facts-header">Интересные факты</h1>
            <div class="facts-accordion">
                <h3>Section 1</h3>
                <div>
                    <p>
                        Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                        ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                        amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                        odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                    </p>
                </div>
                <h3>Section 2</h3>
                <div>
                    <p>
                        Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
                        purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
                        velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
                        suscipit faucibus urna.
                    </p>
                </div>
                <h3>Section 3</h3>
                <div>
                    <p>
                        Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
                        Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
                        ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
                        lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
                    </p>
                    <ul>
                        <li>List item one</li>
                        <li>List item two</li>
                        <li>List item three</li>
                    </ul>
                </div>
                <h3>Section 4</h3>
                <div>
                    <p>
                        Cras dictum. Pellentesque habitant morbi tristique senectus et netus
                        et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
                        faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
                        mauris vel est.
                    </p>
                    <p>
                        Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
                        Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
                        inceptos himenaeos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection