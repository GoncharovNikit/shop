@extends('layouts.template')

@section('content')
<div class="container">

    <div class="card-body">
        @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('Посилання відправлене повторно!') }}
        </div>
        @endif
        <div class="card-header">{{ __('Перед продовженням, перевірте Вашу пошту та підтвердіть Email!') }}</div>
        <div class="card-header" style="margin-top: 273px; margin-bottom: -120px;">{{ __('Не прийшло повідомлення?') }}</div>
        <form style="border: none;" class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button id="verify-mail" type="submit">
                {{ __('Натисніть, щоб запросити ще одне.') }}
            </button>.
        </form>
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection