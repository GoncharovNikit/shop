@extends('layouts.template')

@section('content')
<div class="container">
    <div class="card-header">{{ __('Вхiд') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Пошта') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="form-check">
                    <div class="saveMe" style="width:34%; margin:0 auto; display:flex; flex-direction:row;">
                        <input style="width:40%;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="saveMeLbl" style="width:60%; text-align:center;" class="form-check-label" for="remember">
                            {{ __("Запам'ятати мене") }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <button type="submit" class="btn btn-primary">
                    {{ __('Увійти') }}
                </button>

                <div style="text-align:center; margin-top:10px; margin-bottom:-10px;">
                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Забули пароль?') }}
                    </a>
                    @endif
                </div>
                <div style="text-align:center; margin-top:10px; margin-bottom:-10px;">
                    <a class="btn btn-link" href="{{ route('register') }}" style="font-size: 16pt;">
                        {{ __('Реєстрація') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection