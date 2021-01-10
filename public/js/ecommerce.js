// alert dialog gizlemek için
setTimeout(function () {
    $('.alert-success').slideUp(500);
}, 10000);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function errorMessage(response) {
    if (response.status === 400) {
        const data = JSON.parse(response.responseText);
        alert(data.message)
    }
}


function productVariantAttributeOnChange(productId) {
    let productDetailSelectedAttributes = $("#productDetailsContainer .productVariantAttribute");
    let selectedAttributeIdList = [];
    $.each(productDetailSelectedAttributes, function (index, element) {
        if ($("#" + element.id + " option:selected").attr('data-value') !== undefined)
            selectedAttributeIdList.push($("#" + element.id + " option:selected").attr('data-value'));
    });
    $.ajax({
            url: `/check-product-variant/${productId}`,
            method: 'POST',
            data: {
                'subAttributeIDs': selectedAttributeIdList
            },
            success: function (data) {
                console.log(data);
                $('span.price').text(data.data.variant.price);
                $('span.qty').text(data.data.variant.qty);
                $("#qty").attr('dt-max', data.data.variant.qty).val(1)
            },
            error: function (error) {
                $('span.price').text($("#productDefaultPrice").val());
                $('span.qty').text($("#productDefaultQty").val());
            }
        }
    );
}


function addItemToBasket($productId, $hasProductDetail) {
    if ($hasProductDetail == 1) {
        $("#productQuickView" + $productId + "").click();
    } else {
        var variantCount = $("#productDetailsContainer .productVariantAttribute").length === undefined ? 1 : $("#productDetailsContainer .productVariantAttribute").length;
        var selectedVariants = getProductDetailSelectedAttributeList();
        var selectedVariantCount = selectedVariants.length;
        if (selectedVariantCount < variantCount) {
            alert("Lütfen ürüne ait tüm özellikleri seçiniz");
        } else {
            $.post(`/sepet/addToBasket/${$productId}`, {
                id: $productId,
                selectedAttributeIdList: getProductDetailSelectedAttributeList(),
                qty: $("input#qty").val()
            }, function (data, status) {
                console.log(data)
                if (data.status === true) {
                    basketItemAddToHtml(data.data.card.items, data.data.card.sub_total)
                    $(".mfp-close").click();
                    $(".dropdown-cart-action").removeClass('d-lg-none');
                    $("#openShoppingCart").click();
                } else {
                    alert(data.status.message)
                }
            }).catch(response => {
                errorMessage(response)
            });
        }
    }
}

function removeBasketItem(elem) {
    rowId = $(elem).attr('data-value');
    console.log(elem)
    $.post(`/sepet/removeBasketItem/${rowId}`, function (data, status) {
        if (data.status === true) {
            basketItemAddToHtml(data.data.card.items, data.data.card.sub_total)
            $("#openShoppingCart").click();
        }
    })
}

function getProductDetailSelectedAttributeList() {
    var selectedAttributeList = [];
    $.each($("#productDetailsContainer .productVariantAttribute"), function (index, element) {
        if ($(element).val() !== "")
            selectedAttributeList.push($(element).val())
    });
    return selectedAttributeList;
}


function basketItemAddToHtml(items, cardPrice) {
    var item = '';
    var basketContainer = $("#basketContainer");
    var itemCount = 0;
    basketContainer.html('');
    Object.keys(items).forEach(function (key) {
        var value = items[key];
        itemCount += parseInt(value['qty']);
        item = ' <div class="product">\n' +
            '  <div class="product-details">\n' +
            '      <h4 class="product-title">\n' +
            '          <a href="/urun/' + value['attributes']['product']['slug'] + '">' + value['name'] + '</a>\n' +
            '      </h4>\n' +
            '\n' +
            '      <span class="cart-product-info">\n' +
            '              <span class="cart-product-qty">' + value['quantity'] + '</span>\n' +
            '              x <span class="cart-product-price">' + value['price'] + ' ₺</span>\n' +
            '             <br> <span class="small">' + value['attributes']['attributes_text_lang'] + '</span>\n' +
            '          </span>\n' +
            '  </div><!-- End .product-details -->\n' +
            '\n' +
            '  <figure class="product-image-container">\n' +
            '      <a href="/urun/' + value['attributes']['product']['slug'] + '" class="product-image">\n' +
            '          <img width="80" height="80" src="/uploads/products/' + value['attributes']['product']['image'] + '"\n' +
            '               alt="' + value['name'] + '">\n' +
            '      </a>\n' +
            '      <a href="#" class="btn-remove" title="Ürünü kaldır"  onclick="return removeBasketItem(this)" data-value="' + value['id'] + '"><i class="icon-cancel"></i></a>\n' +
            '  </figure>\n' +
            ' </div>';
        $("#basketContainer").append(item);
    });
    $(".cart-count").text(itemCount);
    $("span.cart-total-price").text(parseFloat(cardPrice).toFixed(2))
    // $("#basketContainer").html(items);
}

/**
 * istek listesine ekler
 * @param productId
 */
function addToFavorites(productId) {
    $.post(`/kullanici/favoriler/${productId}`, function (data) {
        console.log(data)
        if (data.status === true) {
            alert("Favorilere Eklendi")
        }
    }).fail((response, error) => {
        if (response.status === 401) {
            alert('Favorilere eklemeniz için giriş yapmanız gerek.')
        }
    })
}

function getSelectedBrandList() {
    var brandList = new Array();
    var index = 0;

    $($("#productBrandUl li")).each(function () {
        var itemList = [];
        jQuery(this).find(".activeBrand").each(function () {
            if ($(this).attr('data-value') != null) {
                brandList.push(parseInt($(this).attr('data-value')));
            }
        });
        index++;
    });
    return brandList;
}

function getAttrList() {
    var attrList = new Array();
    var index = 0;

    $($("div[id*='attrFilterByID']")).each(function () {
        var itemList = [];
        jQuery(this).find(".activeSubAttribute").each(function () {
            itemList.push(parseInt($(this).attr('value')));
        });
        attrList[index] = new Array(itemList);
        index++;
    });
    return attrList;
}

$('input#q').autocomplete({
    source: function (request, response) {
        $.ajax({
            type: 'GET',
            url: '/headerSearchBarOnChangeWithAjax',
            dataType: "json",
            cache: true,
            success: function (data) {
                var array = $.map(data, function (item) {
                    return {
                        label: item.title,
                        value: item.id
                    }
                });
                response($.ui.autocomplete.filter(array, request.term));
            }
        });
    },
    create: function () {
        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
            return $("<li>")
                .append("<span>" + item.label + "</span>")
                .appendTo(ul);
        };
    }, select: function (event, ui) {
        if (ui.item.value !== 0) {
            window.location.href = "/ara?q=&cat=" + ui.item.value
        }
    }
});
