@extends('layouts.template')
@section('content')
<div id="breadcrumbs">
    <div class="container">
        <ul>
            <li><a href="{{route('shop.main')}}">Головна</a></li>
            <li>Товари</li>
        </ul>
    </div>
    <!-- / container -->
</div>
<!-- / body -->
<div id="body">
    <div class="paging pagination">
        <button class="pagingBut previous round">&#8249;</button>
        <button class="pagingBut next round">&#8250;</button>
    </div>
    <div class="container">
        <div class="products-wrap">
            <!-- sidebar -->
            @include('layouts.partials.sidebar', [$sizes])
            <div id="content">
                <section class="products productList">

                    @foreach ($sales as $sale)
                    <article class="hovarticle productArt<?= count($images[$sale->product->vendorCode]) > 1 ? " to-slide" : "" ?>" data-sizes="{{ json_encode($sale->sizes->pluck('size')) }}" data-category="{{ $sale->product->categories->name_rus }}" data-price="{{ $sale->product->price }}">
                        <img src="{{ asset('images/discount.png') }}" alt="Sale" class="discount-product-image" width="65">
                        <a href="{{ route('shop.sales.single', ['category' => $sale->product->categories->name, 'id' => $sale->product->vendorCode]) }}">
                            <div class="prod-slider">

                                @if (count($images[$sale->product->vendorCode]) > 0)
                                <div class="inner-prod-img-first">
                                    <img class="prod-slider-img" src="{{ asset('images/catalog/'.$sale->product->categories->folder_name.'/'.$sale->product->vendorCode.'/'.$images[$sale->product->vendorCode][0]) }}">
                                </div>
                                @endif
                                @if (count($images[$sale->product->vendorCode]) > 1)
                                <div class="inner-prod-img-second">
                                    <img class="prod-slider-img second-img" src="{{ asset('images/catalog/'.$sale->product->categories->folder_name.'/'.$sale->product->vendorCode.'/'.$images[$sale->product->vendorCode][1]) }}">
                                </div>
                                @endif

                            </div>
                        </a>
                        <div class="art-div">
                            <h3><a href="{{ route('shop.single', ['category' => $sale->product->categories->name, 'id' => $sale->product->vendorCode]) }}">{{ $sale->product->vendorCode }}</a></h3>
                            <h4>
                                <a href="{{ route('shop.single', ['category' => $sale->product->categories->name, 'id' => $sale->product->vendorCode]) }}">
                                    <small>
                                        <strike>
                                            &#8372; {{ round($sale->product->price) }}
                                        </strike>
                                    </small>
                                    <br>
                                    <span style="color:#B92828;">
                                        &#8372; {{round($sale->product->price - ($sale->product->price * $sale->discount / 100))}}
                                    </span>
                                </a>
                            </h4>
                            <div class="prod-description">{{ substr($sale->product->description, 0, 50) }}..</div>
                        </div>
                    </article>
                    @endforeach

                </section>
            </div>
            <!-- / content -->
        </div>
    </div>
    <!-- / container -->
    <div class="paging pagBottom pagination">
        <button class="pagingBut previous round">&#8249;</button>
        <button class="pagingBut next round">&#8250;</button>
    </div>
</div>
<!-- / body -->
@endsection