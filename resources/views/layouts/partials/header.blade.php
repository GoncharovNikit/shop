<header id="header">
    <div class="container">
        <div class="logo-wrapper">
            <a href="{{route('shop.main')}}" id="logo">
                <img src="{{asset('images/avg/LOGOAVG.png')}}" height="110" alt="">
            </a>
        </div>
        <div class="second-header-row">
            <div class="menu-categories-wrapper" hidden>
                <img src="{{asset('images/menu_categories.png')}}" class="header-min-img" alt="">
                <div class="menu-categories" hidden>
                    <ul class="categories-list-menu">
                        @foreach ($categories as $category)
                        <a href="{{ route('shop.list', ['category' => $category->name]) }}">
                            <li class="category-mob-menu">@lang('messages'.$category->name_rus)</li>
                        </a>
                        @endforeach
                        <a href="{{ route('shop.list', ['category' => 'all']) }}">
                            <li class="category-mob-menu">@lang('messages.all_prods_category')</li>
                        </a>
                        <a href="{{ route('shop.list', ['category' => 'sales']) }}">
                            <li class="category-mob-menu">@lang('messages.sales_prods_category')</li>
                        </a>
                    </ul>
                    <div class="lang-wrapper">
                        <img src="{{asset('images/lang.png')}}" class="header-min-img" alt="language">
                        <a href="{{ LaravelLocalization::getLocalizedURL('uk') }}">UK</a>
                        |
                        <a href="{{ LaravelLocalization::getLocalizedURL('ru') }}">RU</a>
                    </div>
                </div>
            </div>
            <div class="darkback" hidden></div>
            <div class="side-doub-wrap">
                <div class="lang-wrapper to-hide">
                    <img src="{{asset('images/lang.png')}}" class="header-min-img" alt="">
                    <a href="{{ LaravelLocalization::getLocalizedURL('uk') }}">UK</a>
                    |
                    <a href="{{ LaravelLocalization::getLocalizedURL('ru') }}">RU</a>
                </div>
                <div class="search-block">
                    <form action="/search" method="GET">
                        <button style="border:none; background:none;" type="submit"><img src="{{asset('images/search.png')}}" class="header-min-img" alt=""></button>
                        <input required type="text" name="search" class="search-input-header to-hide">
                    </form>
                </div>
            </div>
            <div class="logo-plug"></div>
            <div class="side-doub-wrap align-self-right">
                <div class="callback-block-header to-hide">
                    <button class="callback-btn">@lang('messages.callback_btn')</button>
                </div>
                <div class="cart">
                    <a href="{{route('basket')}}">
                        <div class="prod-count" <?= $basket_prod_count < 1 ? "hidden" : "" ?>>
                            {{ $basket_prod_count }}
                        </div>
                        <img src="{{asset('images/basket.png')}}" class="header-min-img" alt="">
                        <span class="to-hide">@lang('messages.basket')</span>
                    </a>
                </div>
            </div>
            <div class="callback-wrapper" hidden>
                <form class="callback-block" method="POST" action="/callback-request">
                    @csrf
                    <label for="phone">@lang('messages.your_phone')</label>
                    <input type="text" name="phone" class="phone-inp">
                    <small>@lang('messages.callback_promise')</small>
                    <button type="submit">@lang('messages.callback_submit')</button>
                </form>
            </div>
            <div id="callback-block-min" hidden>
                <img src="{{asset('images/call.png')}}" class="header-min-img" alt="">
            </div>
        </div>
        <div class="product-categories-row-header">
            <ul class="categories-list">
                @foreach ($categories as $category)
                <li><a href="{{ route('shop.list', ['category' => $category->name]) }}">@lang("messages.{$category->name_rus}")</a></li>
                @endforeach
                <li><a href="{{ route('shop.list', ['category' => 'all']) }}">@lang('messages.all_prods_category')</a></li>
                <li><a href="{{ route('shop.list', ['category' => 'sales']) }}">@lang('messages.sales_prods_category')</a></li>
            </ul>
        </div>
    </div>
    <!-- / container -->
</header>