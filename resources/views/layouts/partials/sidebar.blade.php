<div id="sidebar-show-button">
	<img src="{{ asset('./images/menu.png') }}" alt="">
</div>
<aside id="sidebar">
	<div class="widget">
		<h3>Сортувати за:</h3>
		<fieldset>
			<input type="radio" id="sortDate" name="sorting" class="sort" data-sort="addedDate" checked>
			<label for="sortDate">Датою додавання</label><br>
			<input type="radio" id="sortPriceDesc" name="sorting" class="sort" data-sort="priceDes">
			<label for="sortPriceDesc">Ціною(по спаданню)</label><br>
			<input type="radio" id="sortPriceAsc" name="sorting" class="sort" data-sort="priceAsc">
			<label for="sortPriceAsc">Ціною(по зростанню)</label><br>
		</fieldset>
	</div>
	<div class="widget">
		<h3>Категорії:</h3>
		<fieldset class="category-fieldset">
			<input type="radio" id="all" name="categoryRadio" class="categoryCB" value="all">
			<label for="all">Всі товари</label>
			<br>
			@foreach($categories as $category)
			<input type="radio" id="{{ $category->name }}" name="categoryRadio" <?= $category->name == "Кольца" ? 'checked' : "" ?> class="categoryCB" value="{{$category->id}}">
			<label for="{{ $category->name }}">{{ $category->name }}</label>
			<br>
			@endforeach

		</fieldset>
	</div>
	<div class="widget">
		<h3>Ціновий діапазон:</h3>
		<input type="text" name="minv" id="minv" value="{{$minPrice}}" hidden>
		<input type="text" name="maxv" id="maxv" value="{{$maxPrice}}" hidden>
		<fieldset>
			<div id="price-range"></div>
		</fieldset>
		<br>
	</div>
	<div class="widget" id="sizesWidget">
		<h3>Фільтрація за розмірами:</h3>
		<div id="sizesCBes">
			@foreach($sizes as $size)
			<span class="size_cb_label">
				<input type="checkbox" class="sizeCB" data-size="{{$size->size}}" hidden checked>
				<label>{{$size->size}}</label>
			</span>
			@endforeach
		</div>
		<button type="button" id="checkAll" class="sizes">Включити все</button>
		<button type="button" id="decheckAll" class="sizes">Прибрати все</button>
	</div>
	<br><br><br><br><br>
</aside>