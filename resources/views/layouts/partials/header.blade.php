<header id="header">
    <div class="container">
        <div class="logo-wrapper">
            <a href="{{route('shop.main')}}" id="logo">
                <img src="{{asset('images/avg/LOGOAVG.png')}}" height="130" alt="">
            </a>
        </div>
        <div class="second-header-row">
            <div class="menu-categories-wrapper" hidden>
                <img src="{{asset('images/menu_categories.png')}}" class="header-min-img" alt="">
                <div class="menu-categories" hidden>
                    <ul class="categories-list-menu categories-list">
                        @foreach ($categories as $category)
                        <li class="category-mob-menu"><a href="{{ route('shop.list', ['category' => $category->name]) }}">{{ $category->name_rus }}</a></li>
                        @endforeach
                    </ul>
                    <div class="lang-wrapper">
                        <img src="{{asset('images/lang.png')}}" class="header-min-img" alt="">
                        <a href="{{ LaravelLocalization::getLocalizedURL('uk') }}">UK</a>
                        /
                        <a href="{{ LaravelLocalization::getLocalizedURL('ru') }}">RU</a>
                    </div>
                </div>
            </div>
            <div class="darkback" hidden></div>
            <div class="lang-wrapper align-self-end to-hide">
                <img src="{{asset('images/lang.png')}}" class="header-min-img" alt="">
                <a href="{{ LaravelLocalization::getLocalizedURL('uk') }}">UK</a>
                |
                <a href="{{ LaravelLocalization::getLocalizedURL('ru') }}">RU</a>
            </div>
            <div class="search-block align-self-end">
                <form action="/search" method="GET">
                    <button style="border:none; background:none;" type="submit"><img src="{{asset('images/search.png')}}" class="header-min-img" alt=""></button>
                    <input required type="text" name="search" class="search-input-header to-hide">
                </form>
            </div>
            <div class="logo-plug align-self-end"></div>          
            <div class="callback-block-header align-self-end to-hide">
                <span class="phone-callback">+380(99)-635-04-57</span>
                <button class="callback-btn">Обратный звонок</button>
            </div>
            <div id="callback-block-min" hidden>
                <img src="{{asset('images/call.png')}}" class="header-min-img" alt="">
            </div>
            <div class="callback-wrapper" hidden>
                <form class="callback-block" method="POST" action="/callback-request">
                    @csrf
                    <label for="phone">Ваш номер телефону</label>
                    <input type="text" name="phone" class="phone-inp">
                    <small>Ми Вам передзвонимо!</small>
                    <button type="submit">Підтвердити</button>
                </form>
            </div>
            <div class="cart align-self-end">
                <a href="{{route('basket')}}"><img src="{{asset('images/basket.png')}}" class="header-min-img" alt=""><span class="to-hide">Кошик</span></a>
            </div>
        </div>
        <div class="product-categories-row-header">
            <ul class="categories-list">
                @foreach ($categories as $category)
                <li><a href="{{ route('shop.list', ['category' => $category->name]) }}">{{ $category->name_rus }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- / container -->
</header>