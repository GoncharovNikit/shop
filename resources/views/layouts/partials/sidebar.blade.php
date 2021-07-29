<div id="sidebar-show-button">
	<img src="{{ asset('./images/menu.png') }}" alt="">
</div>
<aside id="sidebar">
	<div class="widget">
		<h3>@lang('messages.sort_by')</h3>
		<fieldset>
			<input type="radio" id="sortPriceDesc" name="sorting" class="sort" data-sort="priceDes">
			<label for="sortPriceDesc">@lang('messages.sort_price_desc')</label><br>
			<input type="radio" id="sortPriceAsc" name="sorting" class="sort" data-sort="priceAsc">
			<label for="sortPriceAsc">@lang('messages.sort_price_asc')</label><br>
			<input type="radio" checked id="sortNewer" name="sorting" class="sort" data-sort="newer">
			<label for="sortNewer">@lang('messages.sort_newer')</label><br>
		</fieldset>
	</div>
	<div class="widget">
		<h3>@lang('messages.price_range')</h3>
		<input type="text" name="minv" id="minv" value="{{$minPrice}}" hidden>
		<input type="text" name="maxv" id="maxv" value="{{$maxPrice}}" hidden>
		<fieldset>
			<div id="price-range"></div>
		</fieldset>
		<br>
	</div>
	<div class="widget" id="sizesWidget">
		<h3>@lang('messages.filter_by_sizes')</h3>
		<div id="sizesCBes">
			@foreach($sizes as $size)
			<span class="size_cb_label">
				<input type="checkbox" class="sizeCB" data-size="{{$size->size}}" hidden checked>
				<label>{{$size->size}}</label>
			</span>
			@endforeach
		</div>
		<button type="button" id="checkAll" class="sizes">@lang('messages.turn_all_on')</button>
		<button type="button" id="decheckAll" class="sizes">@lang('messages.turn_all_off')</button>
	</div>
	<br><br><br><br><br>
</aside>