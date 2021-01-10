// Basket Page And Payment Page


$("#qty").change(function () {
    var dataValue = parseInt($(this).attr("dt-max"));
    var curVal = parseInt($(this).val());
    console.log(curVal, dataValue)
    if (curVal >= dataValue)
        $(this).val(dataValue);
});

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


function updateBasket() {
    var dataItemRowIdAndQty = Create2DArray($("#sepetItemsContainer .basketCartItem").length);
    $("#sepetItemsContainer input[data-type=cartItemRow]").each(function (index, element) {
        dataItemRowIdAndQty[index][0] = element.value;
        dataItemRowIdAndQty[index][1] = $("#" + element.value).val()
    });
    $.post('/sepet/multiple-update', {
        dataItemRowIdAndQty: dataItemRowIdAndQty
    }, function (data, status) {
        if (status === "success") {
            renderUpdatedBasketInfo(data);
        }
    })
}

function Create2DArray(rows) {
    var arr = [];

    for (var i = 0; i < rows; i++) {
        arr[i] = [];
    }

    return arr;
}

function renderUpdatedBasketInfo(data) {
    Object.keys(data.card).forEach(function (key) {
        $key = data[key];
        var selector = $("tr.basketCartItem[data-value=" + key + "]");
        var qty = parseFloat(data.card[key]['qty']);
        var price = parseFloat(data.card[key]['price'])
        selector.find('.price').text((data.card[key]['price']).toFixed(2));
        $("#" + key + "").val(data.card[key]['qty']);
        selector.find('.itemTotalPrice').text((price * qty).toFixed(2));
    });
    console.log(data)
    $("span.cartSubTotal").text(data.cardPrice)
    $("span.cartTotal").text(data.cardTotalPrice)
}

// sepet ürün adet azaltma - arttırma

$('.item-decrement,.item-increment').on('click', function () {
    var product_id = $(this).attr('data-id');
    var qty = $(this).attr('data-qty');
    $.ajax({
        type: 'PATCH',
        url: '/sepet/guncelle/' + product_id,
        data: {qty: qty},
        success: function () {
            window.location.href = '/sepet';
        }
    })
});
