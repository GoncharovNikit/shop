@extends('layouts.template')
@section('content')
<div id="userCard">
  <h1>Вітаємо у особистому кабінеті, {{$user->name}}</h1>
  <br><br>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Товарів в кошику: {{$basketProdCount}}</li>
    <li class="list-group-item">Кількість покупок: {{$ordersCount}}</li>
    <li class="list-group-item">A third item</li>
    <li class="list-group-item">A fourth item</li>
    <li class="list-group-item">And a fifth one</li>
  </ul>
</div>
@endsection