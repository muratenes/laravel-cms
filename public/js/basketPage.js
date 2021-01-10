// taksit sayisini güncelle input hidden

$('#iyzico_installment').on('click', 'input', function () {
    var taksit = $(this).val();
    $("input#taksit_sayisi").val($(this).val())
});


function getInstallmentDetails(totalPrice) {
    let creditCartNumber = $("#kartno").val();
    let listedInstallmentCount = $("#iyzico_installment tbody tr").length;
    creditCartNumber = creditCartNumber.replace(/\-/g, '');
    if (creditCartNumber.length === 16) {
        $.ajax({
            type: 'GET',
            url: '/odeme/taksit-getir',
            dataType: 'json',
            data: {
                totalPrice: totalPrice,
                creditCartNumber: creditCartNumber
            }, success: function (data) {
                $("#taksitContainer").show();
                $("#iyzico_installment tbody").children('tr').remove()
                $(".spBankName").text('- ' + data.installmentDetails[0].bankName);
                $.each(data.installmentDetails[0].installmentPrices, function (i, item) {
                    $tr = $('<tr>').append(
                        $('<td>').html('<span> <input type="radio" class="secili_taksit" id="secilen_taksit" name="secilen_taksit" value=' + item.installmentNumber + '></span>'),
                        $('<td>').text("₺" + item.installmentPrice),
                        $('<td>').text(item.installmentNumber),
                        $('<td>').text("₺" + item.totalPrice),
                    );
                    $("#iyzico_installment").append($tr);
                });
                $("#iyzico_installment input[type='radio']").eq(0).click();
            }, error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
            }
        })
    }
    if (creditCartNumber.length === 0) {
        $("#iyzico_installment tbody").children('tr').remove()
    }

}


// sepet ürün adet azaltma - arttırma
$('body').on('click', '.input-number__add', function () {
    var productID = $(this).attr('data-id');
    var qty = $(`#basketItemProduct_${productID}`).val();
    $.post(`/sepet/addToBasket/${productID}`, {
        qty: 1
    }, function (data) {
        if (data.status === true) {
            reloadBasketItems(data.data.card.items)
            bindPrices(data.data.card)
        } else {
            alert(data.status.message)
        }
    }).catch(response => {
        errorMessage(response)
    });
});

$('body').on('click', '.input-number__sub', function () {
    var productID = $(this).attr('data-cart-id');
    var qty = $(`#basketItemProduct_${productID}`).val();
    $.post(`/sepet/decrement/${productID}`, function (data) {
        if (data.status === true) {
            reloadBasketItems(data.data.card.items)
            bindPrices(data.data.card)
        } else {
            alert(data.status.message)
        }
    }).catch(response => {
        errorMessage(response)
    });
});

/**
 * sepetten ürünü silmek için kullanılır
 * @param rowId
 */
function removeBasketItemFromBasket(rowId) {
    $.post(`/sepet/removeBasketItem/${rowId}`, function (data) {
        if (data.status === true) {
            reloadBasketItems(data.data.card.items)
            bindPrices(data.data.card)
        }
    })
}

/**
 * total,sub_total günceller
 * @param card
 */
function bindPrices(card) {
    $(".cartSubTotalPrice").text(parseFloat(card.sub_total).toFixed(2))
    $(".cartTotalPrice").text(parseFloat(card.total).toFixed(2))
    $(".cartTotalCargPrice").text(parseFloat(card.cargo_price).toFixed(2))
}

/**
 * sepetteki ürünleri listeler
 * @param items
 */
function reloadBasketItems(items) {
    $(".cart-table__body").html('')
    Object.keys(items).forEach(function (key) {
        const item = items[key];
        const totalPrice = parseFloat((item.price + item.attributes.cargo_price) * item.quantity).toFixed(2)
        $(".cart-table__body").append(
            `<tr class="cart-table__row" data-product="${item.id}">
                <td class="cart-table__column cart-table__column--image">
                    <div class="image image--type--product"><a href="${item.attributes.product.slug}" class="image__body">
                    <img class="image__tag" src="/storage/products/${item.attributes['product']['image']}" alt=""></a>
                    </div>
                </td>
                <td class="cart-table__column cart-table__column--product"><a href="${item.attributes.product.slug}" class="cart-table__product-name">${item.name}</a>
                </td>
                <td class="cart-table__column cart-table__column--price" data-title="Fiyat">
                    <span class="oldPrice line-through text-red">${item.attributes.old_price ? `${item.attributes.old_price} ₺` : ''}</span>
                    <span class="currentPrice">${item.price} ₺</span>
                </td>
                <td class="cart-table__column cart-table__column--price" data-title="Fiyat">
                    <span class="currentPrice"> ${item.attributes.cargo_price} ₺</span>
                </td>
                <td class="cart-table__column cart-table__column--quantity" data-title="Adet">
                    <div class="cart-table__quantity input-number">
                        <input class="form-control input-number__input" type="number" min="1" id="basketItemProduct_${item.attributes.product.id}" value="${item.quantity}" readonly>
                        <div class="input-number__add" data-id="${item.attributes.product.id}"></div>
                        <div class="input-number__sub" data-cart-id="${item.id}"></div>
                    </div>
                </td>
                <td class="cart-table__column cart-table__column--total" data-title="Toplam">${totalPrice} ₺</td>
                <td class="cart-table__column cart-table__column--remove" onclick="removeBasketItemFromBasket(${item.id})">
                    <button type="button" class="cart-table__remove btn btn-sm btn-icon btn-muted">
                        <svg width="12" height="12"><path d="M10.8,10.8L10.8,10.8c-0.4,0.4-1,0.4-1.4,0L6,7.4l-3.4,3.4c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L4.6,6L1.2,2.6c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L6,4.6l3.4-3.4c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L7.4,6l3.4,3.4C11.2,9.8,11.2,10.4,10.8,10.8z"></path></svg>
                    </button>
                </td>
            </tr>`
        )
    })
}
