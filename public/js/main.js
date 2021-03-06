$(function () {
  $("#before-load").find("i").fadeOut().end().fadeOut("slow");
});

function mobileCheck() {
  var winWidth = $(window).width();
  if (winWidth <= 768) {
    $("#sidebar").after($("#body .pagination:first"));
  } else {
    $(".products-wrap").before($("#body .pagination:first"));
  }
}

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

  $(".tabs .nav a").on("click", function () {
    var container = $(this).parentsUntil(".tabs").parent();
    if (!$(this).parent().hasClass("active")) {
      container.find(".nav .active").removeClass("active");
      $(this).parent().addClass("active");
      container.find(".tab-content").hide();
      $($(this).attr("href")).show();
    }
    return false;
  });

  $('.phone-inp').mask('+380(99) 999-99-99')
  // $('#card').mask('9999 9999 9999 9999')



  let minv = parseInt($("#minv").val());
  let maxv = parseInt($("#maxv").val());

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

  $("#menu .trigger").on('click', function () {
    $(this).toggleClass("active").next().toggleClass("active");
  });

  mobileCheck();
  $(window).on('resize', function () {
    mobileCheck();
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
      } else if ($(this).data("sort") == "newer") {
        $wrapper
          .find(".productArt")
          .sort(function (a, b) {
            return +a.dataset.id - +b.dataset.id;
          })
          .appendTo($wrapper);
      }

  });

  //PAGINATION
  let currentPage = 1;
  const productsByPage = 16;

  $(".previous").on("click", function () {
    if (currentPage > 1) {
      currentPage--;
      paginateProducts(currentPage);
    }
  });

  $(".next").on("click", function () {
    let countNonFiltered = getNonFilteredProducts().length;
    let pages = countNonFiltered / productsByPage;
    if (countNonFiltered % productsByPage != 0)
      pages++;
    if (currentPage < pages - 2) {
      currentPage++;
      paginateProducts(currentPage);
    }
  });

  //SIZES
  $(".sizeCB").on("change", function () {
    paginateProducts(currentPage)
  });

  $("#checkAll").on("click", function () {
    $(".sizeCB")
      .each((id, elem) => {
        $("label[for='" + $(elem).attr("id") + "']").addClass("checked")
      });
    $(".sizeCB").prop("checked", true);
    paginateProducts(currentPage)
  });

  $("#decheckAll").on("click", function () {
    $(".sizeCB")
      .each((id, elem) => {
        $("label[for='" + $(elem).attr("id") + "']").removeClass("checked")
      });
    $(".sizeCB").prop("checked", false);
    $('.productArt').hide();
    currentPage = 1
  });

  // ???????????????????? ???????????? ?? ??????????????

  $(".basket-adding").on("click", function () {
    $.ajax({
      type: "POST",
      url: "/basket-api",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        vendorCode: $(this).data("vendor"),
        size_id: $("#size").val() ? $("#size").val() : null,
        count: $("#count").val(),
      },
      success: data => {
        let new_count = +$('.prod-count').text() + +data['count']
        if (new_count > 0) {
          $('.prod-count').removeAttr('hidden')
          $('.prod-count').text(new_count)
        }
        $.jGrowl($('html').attr('lang') == 'uk' ? '?????????? ????????????!' : '?????????? ????????????????!', {
          life: 1000,
          position: 'top-right'
        });
      },
      /*error: function (jqXHR, exception) {
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

  // ???????????????? ???????????? ???? ??????????????

  $(".ico-del").on("click", function (e) {
    if (confirm("?????????????????????? ???????????????? ??????????????????!")) {
      e.preventDefault();
      $(this).closest('.cart-tr').remove();

      sum = 0;
      $(".total").each(function () {
        sum += parseFloat(parseFloat($(this).data('total')).toFixed(2));
      });
      $("#totalSum").text('??? ' + sum.toFixed(2));
      $('#totalSum-form').val(sum.toFixed(2));

      $.ajax({
        type: "DELETE",
        url: "/basket-api",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          vendorCode: $(this).data("vendor"),
          size: $(this).parent(".delete").siblings(".size").text() ? $(this).parent(".delete").siblings(".size").text() : null,
          count: $(this).parent(".delete").siblings(".qnt").text(),
        },
        success: data => { 
          $('.prod-count').text(+$('.prod-count').text() - +data['count']);
          +$('.prod-count').text() < 1 ? $('.prod-count').attr('hidden', true) : ''
          refreshTotalSum() 
        },
        /*error: (jqXHR, exception) => {
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
        },*/
      });
    }
  });

  // ?????????????????? ??????_???? ???????????? ?? ??????????????

  $("#sidebar-show-button").on('click', function () {
    $("#sidebar").slideToggle({
      duration: 300,
    });
  });

  $(window).on('resize', function () {

    if (window.innerWidth >= 786) {
      $("#sidebar").show();
    }
    else {
      $("#sidebar").hide();
    }
  });

  $(".menu-categories-wrapper img").on('click', function () {
    $(".menu-categories").slideToggle(200, function () {
      $(".darkback").removeAttr('hidden');
      $('body').css('overflow', 'hidden');
    });
  });
  $('.darkback').on('click', function () {
    $(".menu-categories").hide(200, () => {
      $('body').css('overflow', 'auto');
    })
    $('.callback-wrapper').attr('hidden', true)
    $('.darkback').attr('hidden', true)
  })


  $('.callback-btn, #callback-block-min').on('click', () => {
    $('.callback-wrapper').removeAttr('hidden')
    $('.darkback').removeAttr('hidden')
  })

});

document.addEventListener("DOMContentLoaded", () => {

  $('.to-slide').on('mouseenter', (e) => {
    $('.inner-prod-img-first', e.currentTarget).hide(100)
    $('.inner-prod-img-second', e.currentTarget).show(100)
  }).on('mouseleave', (e) => {
    $('.inner-prod-img-first', e.currentTarget).show(100)
    $('.inner-prod-img-second', e.currentTarget).hide(100)
  })


  $('.to-slide-single').first().bxSlider({
    controls: false,
    pager: true,
    speed: 200,
    pause: 3700,
    auto: true,
    mode: "fade",
    preventDefaultSwipeX: false,
  })

  paginateProducts(1);
  refreshTotalSum();

  // ?????????? ????????????

  $('input[type=radio][name=delivery-radio]').on('change', e => {
    if (e.currentTarget.value == 'novaposhta') {
      $('.deliver-details-novaposhta').removeAttr('hidden')
      $('.deliver-details-novaposhta input').attr('required', true)
      $('.deliver-details-ukrposhta').attr('hidden', true)
      $('.deliver-details-ukrposhta input').removeAttr('required')
    }
    else if (e.currentTarget.value == 'ukrposhta') {
      $('.deliver-details-novaposhta').attr('hidden', true)
      $('.deliver-details-novaposhta input').removeAttr('required')
      $('.deliver-details-ukrposhta').removeAttr('hidden')
      $('.deliver-details-ukrposhta input').attr('required', true)
    }
  })

  // ???? ??????
  
  // ?????????????????????????? ????????????
  // $('#city-np-inp').on('input', e => {
  //   document.querySelector('#cities-np').innerHTML = "";
    
  //   let city_m = e.currentTarget.value
  //   $.post(
  //     "https://api.novaposhta.ua/v2.0/json/",
  //     "{\r\n \"modelName\": \"Address\",\r\n    \"calledMethod\": \"getCities\",\r\n    \"methodProperties\": {\r\n        \"FindByString\": \"" + city_m + "\",\r\n        \"Limit\": 5\r\n    }\r\n}",
  //       data => {
  //         let cities = data.data
  //         let lang = $('html').attr('lang')
  //         let html = ''
  //         cities.forEach((city) => html += `<option value=\"${ lang == 'uk' ? city.Description : city.DescriptionRu }\"><option/>`)
  //         document.querySelector('#cities-np').innerHTML = html
  //       }, 
  //       "json")
  //   })

    
  // $('#otd-np-inp').on('focus', e => {
  //   e.currentTarget.value = ''
  //   document.querySelector('#otds-np').innerHTML = ""

  //   $.post(
  //     "https://api.novaposhta.ua/v2.0/json/",
  //     JSON.stringify({
  //       "modelName": "AddressGeneral",
  //       "calledMethod": "getWarehouses",
  //       "methodProperties": {
  //         "CityName": `${$('#cities-np option').first().val() ?? 'a080fawef80' }`,
  //         "Limit": 5
  //       }
  //     }),
  //     data => {
  //       let otds = data.data
  //       let html = ''
  //       otds.forEach((otd) => html += `<option>${$('html').attr('lang') == 'uk' ? otd.Description : otd.DescriptionRu }<option/>`)
  //       document.querySelector('#otds-np').innerHTML = html
  //     },
  //     "json"
  //   )   
  // })

  $('#city-np-inp').on('input', e => {
    document.querySelector('#cities-np').innerHTML = "";
    
    let city_m = e.currentTarget.value
    $.post(
      "https://api.novaposhta.ua/v2.0/json/",
      "{\r\n \"modelName\": \"Address\",\r\n    \"calledMethod\": \"searchSettlements\",\r\n    \"methodProperties\": {\r\n        \"CityName\": \"" + city_m + "\",\r\n        \"Limit\": 5\r\n    }\r\n}",
        data => {
          let cities = data.data[0].Addresses
          let html = ''
          cities.forEach((city) => html += `<option value=\"${city.Present}\">${city.MainDescription}<option/>`)
          document.querySelector('#cities-np').innerHTML = html
        }, 
        "json")
    })

    
  $('#otd-np-inp').on('focus', e => {
    e.currentTarget.value = ''
    document.querySelector('#otds-np').innerHTML = ""

    $.post(
      "https://api.novaposhta.ua/v2.0/json/",
      JSON.stringify({
        "modelName": "AddressGeneral",
        "calledMethod": "getWarehouses",
        "methodProperties": {
          "CityName": `${$('#cities-np option').first().text()}` 
        }
      }),
      data => {
        let otds = data.data
        let html = ''
        otds.forEach((otd) => html += `<option>${otd.Description}<option/>`)
        document.querySelector('#otds-np').innerHTML = html
      },
      "json"
    )   
  })

  // ???? ??????

  checkSizeInSale()
  $('#size').on('change', e => { checkSizeInSale() })
  setColorsToSaleSizes()


})

function setColorsToSaleSizes() {
  let saleSizes = $('input#sale-sizes').val()
  if(saleSizes === undefined) return
  $('.link').each((id, element) => {
    if (saleSizes.includes($(element).text())) element.style.color = '#B92828'
  })
}

function checkSizeInSale() {
  let saleSizes = $('input#sale-sizes').val()
  if(saleSizes === undefined) return
  let currentSize = $('select#size option:selected').text()
  if (saleSizes.includes(currentSize)) {
    $('.sale-size-price').removeAttr('hidden')
    $('.not-sale-size-price').attr('hidden', true)
  } else {
    $('.sale-size-price').attr('hidden', true)
    $('.not-sale-size-price').removeAttr('hidden')
  }

}

function refreshTotalSum() {
  let sum = 0
  $(".total-price-p").each((id, elem) => {
    sum += parseFloat(parseFloat($(elem).data('total')).toFixed(2))
  })
  
  $("#totalSum").text('??? ' + Math.round(sum))
  $('#totalSum-form').val(Math.round(sum))
}

function getNonFilteredProducts() {
  return $(".productArt")
    .toArray()
    .filter(function (elem) {
      return (
        parseInt($(elem).data("price")) >= parseInt($("#minv").val()) &&
        parseInt($(elem).data("price")) <= parseInt($("#maxv").val()) &&
        isSize(elem)
      )
    })
}

function paginateProducts(currentPage) {
  let products = getNonFilteredProducts();

  $(".productArt").hide();
  for (let i = 20 * (currentPage - 1); i <= 20 * currentPage - 1; i++) {
    try {
      $(products[i]).show();
    } catch (e) { }
  }
}

function isSize(elem) {
  //???????????????? ?????????????? ?????????????? ???????????? ?? ???????????? ??????????????
  if (
    $(elem).data("category") != "????????????" &&
    $(elem).data("category") != "????????????????"
  )
    return true;

  let sizes = $(elem).data("sizes");
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
  return false;
}
