@extends('layouts.template')

@section('content')

<div class="container">
    <div class="card-header" style="margin-top:100px;">{{ __('Відновити пароль через пошту') }}</div>

    <div class="card-body" style="margin-bottom:195px;">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ __('Посилання на відновлення відправлене!') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Пошта') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert" style="color:#C62525;">
                    <strong>{{ __('Користувач з заданою поштою не знайдений!') }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row mb-0">
                <button type="submit" class="btn btn-primary send-reset">
                    {{ __('Відновити') }}
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>

@endsection