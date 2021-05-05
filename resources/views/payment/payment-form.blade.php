@extends('layouts.template')

@section('content')
<div class="container">
    <div class="card-header">{{ __('Оформлення заказу') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('order.check') }}">
            @csrf

            <h1 style="text-align: center; margin-bottom:20px;">До сплати: ₴ {{ $amount }}</h1>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ПІБ отримувача') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? Auth::user()->name ?? '' }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Пошта') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') ?? Auth::user()->email ?? '' }}" autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            
            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Номер телефону') }}</label>

                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                    name="phone" value="{{ old('phone') }}" required>

                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="card" class="col-md-4 col-form-label text-md-right">{{ __('Номер банківської карти') }}</label>

                <input id="card" type="text" class="form-control @error('card') is-invalid @enderror" 
                    name="card" value="{{ old('card') }}" required>

                @error('card')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row mb-0">
                <button type="submit" class="btn btn-primary">
                    {{ __('Підтвердити замовлення') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection