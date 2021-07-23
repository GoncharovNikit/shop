@extends('layouts.template')

@section('content')
@if ($product->sale_count > 0)
<style>
	.option,
	.link {
		/* color: #B92828; */
	}
</style>
@endif
<div id="breadcrumbs">
	<div class="container">
		<ul>
			<li><a href="{{route('shop.main')}}">Головна</a></li>
			<li><a href="{{route('shop.list', ['category' => 'sales'])}}">Акции</a></li>
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
					<h1>
						@if ($product->sale_count > 0)
						<input type="text" id="sale-sizes" value="{{ json_encode(array_column($product->sale->sizes->toArray(), 'size')) }}" hidden>
						<div class="sale-size-price" hidden>
							<strike><small>&#8372; {{$product->price}}</small></strike> <span style="white-space: nowrap; color:#B92828;">&#8372; {{$product->discount_price}}</span>
						</div>
						<div class="not-sale-size-price">
							&#8372; {{$product->price}}
						</div>
						@else
						&#8372; {{$product->price}}
						@endif
					</h1>
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
								@if ($product->is_sale_page)
									@forelse($product->sale->sizes as $size)
									<option value="{{$size->id}}">{{$size->size}}</option>
									@empty
									Товар тимчасово недоступний!
									@endforelse
								@else
									@forelse($product->sizes as $size)
									<option value="{{$size->id}}">{{$size->size}}</option>
									@empty
									Товар тимчасово недоступний!
									@endforelse
								@endif
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