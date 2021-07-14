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

                <input type="text" class="form-control @error('phone') is-invalid @enderror phone-inp" name="phone" value="{{ old('phone') }}" required>

                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="payment-wrapper">
                    <div class="col-md-4 col-form-label text-md-right payment-label">
                        Спосіб оплати
                    </div>
                    <div class="payment-type">
                        <div class="payment-type-items">
                            <div class="payment-type-item">
                                <input type="radio" name="payment-radio" value="card" id="card-pay-inp" checked />
                                <label for="card-pay-inp">Карткою одразу</label>
                            </div>
                            <div class="payment-type-item">
                                <input type="radio" name="payment-radio" value="nal" id="nal-pay-inp" />
                                <label for="nal-pay-inp">При отриманні (з передоплатою)</label>
                            </div>
                        </div>
                    </div>
                </div>

                @error('payment-type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group row">
                <label for="card" class="col-md-4 col-form-label text-md-right">{{ __('Номер банківської карти') }}</label>

                <input id="card" type="text" class="form-control @error('card') is-invalid @enderror" name="card" value="{{ old('card') }}" required>

                @error('card')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="payment-wrapper">
                    <div class="col-md-4 col-form-label text-md-right payment-label">
                        Спосіб доставки
                    </div>
                    <div class="payment-type">
                        <div class="payment-type-items">
                            <div class="payment-type-item">
                                <input type="radio" name="deliver-radio" value="novaposhta" id="novaposhta-inp" checked />
                                <label for="novaposhta-inp">Нова пошта</label>
                            </div>
                            <div class="payment-type-item">
                                <input type="radio" name="deliver-radio" value="ukrposhta" id="ukrposhta-inp" />
                                <label for="ukrposhta-inp">Укр пошта</label>
                            </div>
                        </div>
                    </div>
                </div>

                @error('payment-type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row deliver-details-wrapper">
                <h2 class="form-h2">Дані доставки</h2>
                <div class="deliver-details-novaposhta">
                    <div class="np-details-item">
                        <label for="city-np-inp" class="col-md-4 col-form-label text-md-right">Місто</label>
                        <input type="text" list="cities-np" class="form-control @error('name') is-invalid @enderror" name="city-np" required id="city-np-inp" />
                        <datalist id="cities-np">
                        </datalist>
                    </div>
                    <div class="np-details-item">
                        <label for="otd-np-inp" class="col-md-4 col-form-label text-md-right">Відділення/поштомат</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="otd-np" required id="otd-np-inp" />
                    </div>
                </div>
                <div class="deliver-details-ukrposhta" hidden>
                    <div class="up-details-item">
                        <label for="city-up-inp" class="col-md-4 col-form-label text-md-right">Місто</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="city-up" id="city-up-inp" />
                    </div>
                    <div class="up-details-item">
                        <label for="otd-up-inp" class="col-md-4 col-form-label text-md-right">Індекс відділення</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="otd-up" id="otd-up-inp" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <h2 class="form-h2"2>Примітки</h2>
                <textarea name="notes" id="notes" class="form-control @error('name') is-invalid @enderror"></textarea>
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