@extends('layouts.template')

@section('content')
<div id="breadcrumbs">
	<div class="container">
		<ul>
			<li><a href="{{route('shop.main')}}">@lang('messages.breadcrumbs.main')</a></li>
			<li><a href="{{route('shop.list', ['category' => 'all'])}}">@lang('messages.breadcrumbs.products')</a></li>
			<li>@lang('messages.breadcrumbs.single')</li>
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
						<li><img src="{{ asset('images/catalog/'.$product->categories->folder_name.'/'.$product->vendorCode.'/'.$img) }}" /></li>
						@endforeach
					</ul>
				</div>
				<div class="details">
					<h3>{{$product->vendorCode}}</h3>
					<h1>
						@if ($product->sale_count > 0)
						<input type="text" id="sale-sizes" value="{{ json_encode(array_column($product->sale->sizes->toArray(), 'size')) }}" hidden>
						<div class="sale-size-price fullsale-relative" hidden>
							<strike><small>&#8372; {{round($product->price)}}</small></strike> <span style="white-space: nowrap; color:#B92828;">&nbsp;&#8372; {{round($product->discount_price)}}</span>
							@if (count($product->sizes) == count($product->sale->sizes ?? []))
							<img src="{{ asset('images/sale.png') }}" class="single-prod-fullsale-img" alt="sale" width="55">
							@endif
						</div>
						<div class="not-sale-size-price">
							&#8372; {{round($product->price)}}
						</div>
						@else
						&#8372; {{round($product->price)}}
						@endif
					</h1>
					<br>
					<div class="entry">
						<p>{{$product->description}}</p>
					</div>
					<div class="actions">
						<div class="action-item">
							<label for="count">@lang('messages.single_count')</label>
							<input type="number" name="count" id="count" min="1" max="1000" value="1">
						</div>

						@if($product->categories->name_rus == 'Кольца' || $product->categories->name_rus == 'Браслеты')
						<div class="action-item relative-img-sale">
							@if (count($product->sizes) != count($product->sale->sizes ?? []) && $product->sale_count)
							<img src="{{ asset('images/sale.png') }}" class="single-prod-sale-img" alt="sale" width="35">
							@endif
							<label>@lang('messages.single_size')</label>
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

						<button class="btn-grey basket-adding action-item" data-vendor="{{$product->vendorCode}}">@lang('messages.single_add_to_basket')</button>
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