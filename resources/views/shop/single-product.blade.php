@extends('layouts.template')

@section('content')

<div id="breadcrumbs">
	<div class="container">
		<ul>
			<li><a href="{{route('shop.main')}}">Головна</a></li>
			<li><a href="{{route('shop.list', ['category' => 'all'])}}">Товари</a></li>
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
				<div class="slider-wrapper">
					<ul class="<?= count($images) > 1 ? 'to-slide-single' : ''; ?>">
						@foreach ($images as $img)
						<li><img src="{{ asset('images/cat/'.$product->categories->folder_name.'/'.$product->vendorCode.'/'.$img) }}" /></li>
						@endforeach
					</ul>
				</div>
				<div class="details">
					<h3>{{$product->vendorCode}}</h3>
					<h1>&#8372; {{$product->price}}</h1>
					<br>
					<div class="entry">
						<p>{{$product->description}}</p>
					</div>
					<div class="actions">
						<div class="action-item">
							<label for="count">Кілкість:</label>
							<input type="number" name="count" id="count" min="1" max="1000" value="1">
						</div>

						@if($product->categories->name_rus == 'Кольца' || $product->categories->name_rus == 'Браслеты')
						<div class="action-item">
							<label>Розмір:</label>
							<select name="size" id="size">
								@forelse($product->sizes as $size)
								<option value="{{$size->id}}">{{$size->size}}</option>
								@empty
								Товар тимчасово недоступний!
								@endforelse
							</select>
						</div>
						@endif

						<button class="btn-grey basket-adding action-item" data-vendor="{{$product->vendorCode}}">Додати до кошика</button>
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