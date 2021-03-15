<header id="header">
    <div class="container">
        <a href="{{route('shop.main')}}" id="logo" title="Avangard jewelry factory">Avangard jewelry</a>
        <div class="right-links">
            <ul>
                <li><a href="{{route('basket')}}"><span class="ico-products"></span>Кошик</a></li>
                <li><a href="{{Auth::check()?route('personal', Auth::id()):route('login')}}"><span class="ico-account"></span>Акаунт</a></li>
                <li>
                    @if(Auth::check())
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <span class="ico-signout"></span> Вийти
                    </a>
                    @else
                    <a href="{{ route('shop.main') }}">
                        <span class="ico-signout"></span> Вийти
                    </a>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        Вийти
                    </form>
                </li>
                <li>
                    @if(Auth::check() && Auth::id() == 1)
                    <a href="{{ route('admin') }}">Адмін-панель</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
    <!-- / container -->
</header>