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

<div id="body">
    <div class="container">
        <div class="last-products">
            <h2>Last added products</h2>
            <section class="products">

                @foreach($products as $product)
                <article style="position:relative;">

                    <a href="{{route('shop.single', ['id'=>$product->vendorCode])}}"><img src="{{asset('images/cat/'.$product->categories->name.'/'.$product->vendorCode.'.jpg')}}" width="194" alt="https://via.placeholder.com/194x210"></a>

                    <div style="position: absolute; bottom: 20px; width: 100%;">
                        <h3><a href="{{route('shop.single', ['id'=>$product->vendorCode])}}">{{$product->vendorCode}}</a></h3>
                        <!-- <small>{{$product->vendorCode}}</small> -->

                        <h4><a href="{{route('shop.single', ['id'=>$product->vendorCode])}}">&#8372; {{$product->price}}</a></h4>
                        <!-- <small>Category: {{$product->categories->name}}</small> -->
                    </div>

                </article>
                @endforeach

            </section>
        </div>
        <section class="quick-links">
            <article style="background-image: url({{asset('images/avg/f1.jpg')}}); background-size: cover;">
                <a href="#" class="table">
                    <div class="cell">
                        <div class="text">
                            <h4>Lorem ipsum</h4>
                            <hr>
                            <h3>Dolor sit amet</h3>
                        </div>
                    </div>
                </a>
            </article>
            <article class="red" style="background-image: url({{asset('images/avg/f2.jpg')}}); background-size: cover;">
                <a href="#" class="table">
                    <div class="cell">
                        <div class="text">
                            <h4>consequatur</h4>
                            <hr>
                            <h3>voluptatem</h3>
                            <hr>
                            <p>Accusantium</p>
                        </div>
                    </div>
                </a>
            </article>
            <article style="background-image: url({{asset('images/avg/f3.jpg')}}); background-size: cover;">
                <a href="#" class="table">
                    <div class="cell">
                        <div class="text">
                            <h4>culpa qui officia</h4>
                            <hr>
                            <h3>magnam aliquam</h3>
                        </div>
                    </div>
                </a>
            </article>
        </section>
    </div>
    <!-- / container -->
</div>
<!-- / body -->

@endsection