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