@extends('layouts.template')

@section('content')

<div id="slider">
    <ul>
        <li style="background-image: url({{asset('images/p4.jpg')}});">
            <h3>Make your life better</h3>
            <h2>Genuine diamonds</h2>
            <a href="#" class="btn-more">Read more</a>
        </li>
        <li class="purple" style="background-image: url({{asset('images/p2.jpg')}})">
            <h3>She will say “yes”</h3>
            <h2>engagement ring</h2>
            <a href="#" class="btn-more">Read more</a>
        </li>
        <li class="yellow" style="background-image: url({{asset('images/p3.jpg')}})">
            <h3>You deserve to be beauty</h3>
            <h2>golden bracelets</h2>
            <a href="#" class="btn-more">Read more</a>
        </li>
    </ul>
</div>

<!-- / body -->

<div class="body">
    <!-- <h1>@lang('messages.welcome')</h1> -->
    <div class="container">
        <div class="last-products">
            <h2 style="font-size:24pt;font-family:'Courier New', Helvetica, sans-serif; font-weight:0; letter-spacing:5px;">Новинки</h2>
            <section class="products">

                @foreach($products as $product)
                <article style="padding-top: 60px;" style="position:relative;">

                    <a href="{{route('shop.single', ['category' => $product->categories->name, 'id'=>$product->vendorCode])}}"><img src="{{asset('images/cat/'.$product->categories->name_rus.'/'.$product->vendorCode.'.jpg')}}" width="194" alt="https://via.placeholder.com/194x210"></a>

                    <div style="position: absolute; bottom: 20px; width: 100%;border:none;">
                        <h3><a href="{{route('shop.single', ['category' => $product->categories->name, 'id'=>$product->vendorCode])}}">{{$product->vendorCode}}</a></h3>
                        <!-- <small>{{$product->vendorCode}}</small> -->

                    </div>

                </article>
                @endforeach

            </section>
        </div>
        <section class="quick-links">
            <article id="art-link-1" class="article-link">
                <img src="{{asset('images/avg/f1.jpg')}}" alt="">
                <h1>@lang('messages.qlink1')</h1>
            </article>
            <article id="art-link-2" class="article-link">
                <img src="{{asset('images/avg/f2.jpg')}}" alt="">
                <h1>@lang('messages.qlink2')</h1>
            </article>
            <article id="art-link-3" class="article-link">
                <img src="{{asset('images/avg/f3.jpg')}}" alt="">
                <h1>@lang('messages.qlink3')</h1>
            </article>
        </section>
    </div>
    <!-- / container -->
</div>
<!-- / body -->


<div class="body">
    <div id="about-wrap">
        <h1>AVANGARD</h1>
        <div id="about-text">
            @lang('messages.about')
        </div>
    </div>
</div>

@endsection