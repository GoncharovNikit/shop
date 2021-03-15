//const { round } = require("lodash");

//const { forEach } = require("lodash");
$(function () {
  $("#before-load").find("i").fadeOut().end().delay(100).fadeOut("slow");
});

function mobileCheck() {
  var winWidth = $(window).width();
  if (winWidth <= 768) {
    $("#sidebar").after($("#body .pagination:first"));
  } else {
    $(".products-wrap").before($("#body .pagination:first"));
  }
}

const rootDir = '/';

$(function () {
  
  $("input[type=checkbox]").crfi();
  $("select").crfs();
  $("#slider ul").bxSlider({
    controls: false,
    auto: true,
    mode: "fade",
    preventDefaultSwipeX: false,
  });
  $(".last-products .products").bxSlider({
    pager: false,
    minSlides: 1,
    maxSlides: 5,
    slideWidth: 235,
    slideMargin: 0,
  });
  $(".tabs .nav a").click(function () {
    var container = $(this).parentsUntil(".tabs").parent();
    if (!$(this).parent().hasClass("active")) {
      container.find(".nav .active").removeClass("active");
      $(this).parent().addClass("active");
      container.find(".tab-content").hide();
      $($(this).attr("href")).show();
    }
    return false;
  });

  





  let minv = parseInt($("#minv").val());
  let maxv = parseInt($("#maxv").val());
  let currentCategory = 1;

  $("#price-range").slider({
    step: 1,
    range: true,
    min: minv,
    max: maxv,
    values: [minv, maxv],
    slide: function (event, ui) {
      $(".ui-slider-handle:first").html(
        "<span>&#8372; " + ui.values[0] + "</span>"
      );
      $("#minv").val(ui.values[0]);
      $(".ui-slider-handle:last").html(
        "<span>&#8372; " + ui.values[1] + "</span>"
      );
      $("#maxv").val(ui.values[1]);

      currentPage = 1;
      paginateProducts(currentPage);
    },
  });

  $(".ui-slider-handle:first").html(
    "<span>&#8372; " + $("#price-range").slider("values", 0) + "</span>"
  );

  $(".ui-slider-handle:last").html(
    "<span>&#8372; " + $("#price-range").slider("values", 1) + "</span>"
  );

  $("#menu .trigger").click(function () {
    $(this).toggleClass("active").next().toggleClass("active");
  });

  mobileCheck();
  $(window).resize(function () {
    mobileCheck();
  });

  $(".categoryCB").on("change", function () {
    currentCategory = $(this).val();

    if (!(currentCategory == 1 || currentCategory == 7)) {
      $("#sizesWidget").hide();
    } else $("#sizesWidget").show();

    currentPage = 1;
    upload_products_ajax(currentCategory, currentPage);
  });

  let $wrapper = $(".products");

  $(".sort").on("change", function () {
    if ($(this).data("sort") == "priceDes") {
      $wrapper
        .find(".productArt")
        .sort(function (a, b) {
          return +b.dataset.price - +a.dataset.price;
        })
        .appendTo($wrapper);
    } else if ($(this).data("sort") == "priceAsc") {
      $wrapper
        .find(".productArt")
        .sort(function (a, b) {
          return +a.dataset.price - +b.dataset.price;
        })
        .appendTo($wrapper);
    }
  });

  //PAGINATION
  let currentPage = 1;
  const productsByPage = 20;

  $(".previous").on("click", function () {
    if (currentPage > 1) {
      currentPage--;
      paginateProducts(currentPage);
    }
  });

  $(".next").on("click", function () {
    // alert('next start');
    let pages = getNonFilteredProducts().length / productsByPage;
    // alert('pages has counted');
    if (getNonFilteredProducts().length % productsByPage != 0)
      pages++;
    if (currentPage < pages - 1) {
      currentPage++;
      paginateProducts(currentPage);
    }
  });

  //SIZES
  $(".sizeCB").on("change", function () {
    paginateProducts(currentPage);
  });  

  $("#checkAll").on("click", function () {
    $(".sizeCB")
      .toArray()
      .forEach(function (elem) {
        $("label[for='" + $(elem).attr("id") + "']").addClass("checked");
      });
    $(".sizeCB").prop("checked", true);
    paginateProducts(currentPage);
  });

  $("#decheckAll").on("click", function () {
    $(".sizeCB")
      .toArray()
      .forEach(function (elem) {
        $("label[for='" + $(elem).attr("id") + "']").removeClass("checked");
      });
    $(".sizeCB").prop("checked", false);
    $('.productArt').hide();
    currentPage = 1;
    //paginateProducts(currentPage);
  });

  // ДОБАВЛЕНИЕ ТОВАРА В КОРЗИНУ

  $(".basket-adding").on("click", function () {
    $.jGrowl('Товар додано!', {
      life: 1000,
      position: 'top-right'
    });
    $.ajax({
      type: "POST",
      url: rootDir + "basket",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        vendorCode: $(this).data("vendor"),
        size_id: $("#size").val()?$("#size").val():null,
        count: $("#count").val(),
      },
      /*success: function(){
        alert('Added!");
      },
      error: function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        alert(msg);
      },*/
    });
  });

  // УДАЛЕНИЕ ТОВАРА ИЗ КОРЗИНЫ

  $(".ico-del").on("click", function (e) {
    if (confirm("Підтвердіть операцію видалення!")) {
      e.preventDefault();
      $(this).closest('.cart-tr').remove();

      sum = 0;
      $(".total").each(function(){
          sum += parseFloat(parseFloat($(this).data('total')).toFixed(2));
      });
      $("#totalSum").text('₴ ' + sum.toFixed(2));

      $.ajax({
        type: "DELETE",
        url: rootDir + "basket",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          vendorCode: $(this).data("vendor"),
          size: $(this).parent(".delete").siblings(".size").text()?$(this).parent(".delete").siblings(".size").text():null,
          count: $(this).parent(".delete").siblings(".qnt").children().first().val(),
        },
        /*success: function () {
          alert('Deleted!");
        },
        error: function (jqXHR, exception) {
          var msg = "";
          if (jqXHR.status === 0) {
            msg = "Not connect.\n Verify Network.";
          } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
          } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
          } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
          } else if (exception === "timeout") {
            msg = "Time out error.";
          } else if (exception === "abort") {
            msg = "Ajax request aborted.";
          } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
          }
          alert(msg);
        },  */
      });
    }
  });

  // ИЗМЕНЕНИЕ КОЛ_ВА ТОВАРА В КОРЗИНЕ

  let sum = 0;
  $(".total").each(function(index){
    if(index != 0){
      sum += parseFloat(parseFloat($(this).data('total')).toFixed(2));
    }
  });
  $("#totalSum").text('₴ ' + sum.toFixed(2));
  
  $(".countinp").on("change", function(){
    sum = ($(this).data("singleprice") * $(this).val()).toFixed(2);
    $(this).parent(".qnt").siblings(".total").text('$ ' + sum);
    $(this).parent(".qnt").siblings(".total").data('total', sum);
    sum = 0;
    $(".total").each(function(index){
      if(index != 0){
        sum += parseFloat(parseFloat($(this).data('total')).toFixed(2));
      }
    });
    
    $("#totalSum").text('₴ ' + sum.toFixed(2));
  });


  upload_products_ajax(1, currentPage);
  
  $( document ).ajaxComplete(function(){
    //alert('ajax complete");
    paginateProducts(currentPage);
  });
});

function getNonFilteredProducts() {
  //alert('get non filtered products");
  return $(".productArt")
    .toArray()
    .filter(function (elem) {
      return (
        parseInt($(elem).data("price")) >= parseInt($("#minv").val()) &&
        parseInt($(elem).data("price")) <= parseInt($("#maxv").val()) &&
        isSize(elem)
      );
    });
}

function paginateProducts(currentPage) {
  //alert('paginate products');
  let products = getNonFilteredProducts();
  //alert('paginate products after get non filtered");
  // console.log(products);
  $(".productArt").hide();

  for (let i = 20 * (currentPage - 1); i <= 20 * currentPage - 1; i++) {
    try {
      $(products[i]).show();
    } catch (e) {}
  }
}

function csl(item) {
  console.log(item);
}

function isSize(elem) {
  // alert('is size func');
  //Проверка наличия размера товара в списке товаров
  if (
    $(elem).data("category") != "Кольца" &&
    $(elem).data("category") != "Браслеты"
  )
    return true;
    
  //console.log($(elem).data("sizes").split(','));

  let sizes = $(elem).data("sizes").split(',');
  let cbs = $(".sizeCB").toArray();
  for (let i = 0; i < sizes.length; i++) {
    for (let j = 0; j < cbs.length; j++) {
      if (
        sizes[i] == $(cbs[j]).data("size") &&
        $(cbs[j]).is(":checked")
      ) {
        return true;
      }
    }
  }
  // alert('is size end');
  return false;
}


function upload_products_ajax(index, currentPage)
{
  //alert('uploading products');
  $(".productList").empty();
  
  $.get(rootDir + "api/products/category/" + index, function(data){

    let productArr = $.parseJSON(data);

    //перебираем все товары из json
    productArr.forEach(function(elem){

    // console.log(productArr);
      // получаем массив размеров товара

    let sizeArr = elem.sizes.map(function(val){
      return val.size;
    })  
      /* 
    let sizeArr = [];
    elem.sizes.forEach(function(obj){
      sizeArr.push(obj.size);
    }); */

    // заполняем товар
    let product = `
    <article 
						data-sizes="`+ sizeArr +`" 
						style="position:relative;" 
						class="productArt" 
						data-category="` + elem.categories.name + `" 
						data-price="` + elem.price + `">

						<a href="` + rootDir + `list/` + elem.vendorCode + `">
							<img 
								src="` + rootDir + `images/cat/` + elem.categories.name + `/` + elem.vendorCode + `.jpg" 
								width="194" alt="https://via.placeholder.com/194x210">
						</a>

						<div style="position: absolute; bottom: 20px; width: 100%;">
							<h3><a href="` + rootDir + `list/` + elem.vendorCode + `">` + elem.vendorCode + `</a></h3>

							<h4><a href="` + rootDir + `list/` + elem.vendorCode + `">&#8372; ` + elem.price + `</a></h4>
							<small style="padding:3px;">` + elem.description.substring(0, 50) + `</small>
						</div>
					</article>`;

          $(".productList").append(product);
    });

  });//.done(function() { setTimeout(paginateProducts, 4000, currentPage); } );
  

}