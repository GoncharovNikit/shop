@extends('layouts.template')

@section('content')

<div id="breadcrumbs">
	<div class="container">
		<ul>
			<li><a href="{{route('shop.main')}}">Головна</a></li>
			<li><a href="{{route('shop.list')}}">Товари</a></li>
			<li>Перегляд товару</li>
		</ul>
	</div>
	<!-- / container -->
</div>
<!-- / body -->

<div id="body">
	<div class="container">
		<div id="content" class="full">
			<div class="product">
				<div class="image">
					<img src="{{asset('images/cat/'.$product->categories->name.'/'.$product->vendorCode.'.jpg')}}" alt="">
				</div>
				<div class="details">
					<h3>{{$product->vendorCode}}</h3>
					<h1 style="font-size: 40pt;">&#8372; {{$product->price}}</h1>
					<br>
					<div class="entry">
						<p>{{$product->description}}</p>
					</div>
					<div class="actions">
						<label for="count">Кілкість:</label>
						<input type="number" name="count" id="count" min="1" max="1000" value="1">
						<br>
						@if($product->categories->id == 7 || $product->categories->id == 1)
						<label>Розмір:</label>
						<select name="size" id="size">
							@forelse($product->sizes as $size)
							<option value="{{$size->id}}">{{$size->size}}</option>
							@empty
							Товар тимчасово недоступний!
							@endforelse
						</select>
						<br>
						@endif
						<button class="btn-grey basket-adding" data-vendor="{{$product->vendorCode}}">Додати до кошика</button>
					</div>
				</div>
			</div>
		</div>
		<!-- / content -->
	</div>
	<!-- / container -->
</div>
<!-- / body -->

@endsection