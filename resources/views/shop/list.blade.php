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

					<article class="hovarticle productArt" data-sizes="{{ json_encode($product->sizes->pluck('size')) }}" data-category="{{ $product->categories->name_rus }}" data-price="{{ $product->price }}">
						<a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">
							<div class="prod-slider<?= count($images[$product->vendorCode]) > 1 ? ' to-slide':''; ?>">
							@foreach ($images["$product->vendorCode"] as $img)
								<div><img class="prod-slider-img" src="{{ asset('images/cat/'.$product->categories->name_rus.'/'.$product->vendorCode.'/'.$img) }}"></div>
							@endforeach
							</div>
						</a>
						<div class="art-div">
							<h3><a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">{{ $product->vendorCode }}</a></h3>
							<h4><a href="{{ route('shop.single', ['category' => $product->categories->name, 'id' => $product->vendorCode]) }}">&#8372; {{ $product->price }}</a></h4>
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