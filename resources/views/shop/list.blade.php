@extends('layouts.template')
@section('content')
<div id="breadcrumbs">
	<div class="container">
		<ul>
			<li><a href="{{route('shop.main')}}">Головна</a></li>
			<li>Товари</li>
		</ul>
	</div>
	<!-- / container -->
</div>
<!-- / body -->

<div id="body">
	<div class="paging pagination">
		<button class="pagingBut previous round">&#8249;</button>
		<button class="pagingBut next round">&#8250;</button>
	</div>

	<div class="container">
		<div class="products-wrap">
			<!-- sidebar -->
			@include('layouts.partials.sidebar', [$sizes])
			<div id="content">
				<section class="products productList">

					@foreach ($products as $product)

					<article class="hovarticle productArt<?= count($images[$product->vendorCode]) > 1 ? " to-slide" : "" ?>" data-sizes="{{ json_encode($product->sizes->pluck('size')) }}" data-category="{{ $product->categories->name_rus }}" data-price="{{ $product->price }}">
						@if ($product->sale_count > 0)
						<img src="{{ asset('images/discount.png') }}" alt="Sale" class="discount-product-image" width="65">
						@endif
						<a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">
							<div class="prod-slider">

								@if (count($images[$product->vendorCode]) > 0)
								<div class="inner-prod-img-first"><img class="prod-slider-img" src="{{ asset('images/catalog/'.$product->categories->folder_name.'/'.$product->vendorCode.'/'.$images[$product->vendorCode][0]) }}"></div>
								@endif
								@if (count($images[$product->vendorCode]) > 1)
								<div class="inner-prod-img-second"><img class="prod-slider-img second-img" src="{{ asset('images/catalog/'.$product->categories->folder_name.'/'.$product->vendorCode.'/'.$images[$product->vendorCode][1]) }}"></div>
								@endif

							</div>
						</a>
						<div class="art-div">
							<h3><a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">{{ $product->vendorCode }}</a></h3>
							@if ($product->sale_count > 0 && count($product->sizes) == count($product->sale->sizes ?? []))
							<h4>
								<a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">
									<small>
										<strike>
											&#8372; {{ round($product->price) }}
										</strike>
									</small>
									<br>
									<span style="color:#B92828;">
										&#8372; {{round($product->price - ($product->price * $product->sale->discount / 100))}}
									</span>
								</a>
							</h4>
							@else
							<h4><a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">&#8372; {{ round($product->price) }}</a></h4>
							@endif
							<div class="prod-description">{{ substr($product->description, 0, 50) }}..</div>
						</div>
					</article>

					@endforeach

				</section>
			</div>
			<!-- / content -->
		</div>
	</div>
	<!-- / container -->
	<div class="paging pagBottom pagination">
		<button class="pagingBut previous round">&#8249;</button>
		<button class="pagingBut next round">&#8250;</button>
	</div>
</div>
<!-- / body -->
@endsection