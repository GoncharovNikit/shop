@extends('layouts.template')

@section('content')
<div class="container">
    <div class="card-header">{{ __('Оформлення заказу') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('order.check') }}">
            @csrf

            <h1 style="text-align: center; margin-bottom:20px;">До сплати: <span style="white-space: nowrap">₴ {{ $amount }}</span></h1>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ПІБ отримувача') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? '' }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Номер телефону') }}</label>

                <input type="text" class="form-control @error('phone') is-invalid @enderror phone-inp" 
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

            <div class="form-group row">
                <label for="payment-type">Оплата</label>

                <select name="payment-type" id="payment-type" class="form-control @error('payment-type') is-invalid @enderror" value="{{ old('payment-type') }}" required>
                    <option value="card">Сплатити одразу карткою</option>
                    <option value="cash">Сплатити при отриманні</option>
                </select>

                @error('payment-type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row mb-0">
                <button type="submit" id="order-request-send" class="btn btn-primary">
                    {{ __('Підтвердити замовлення') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection