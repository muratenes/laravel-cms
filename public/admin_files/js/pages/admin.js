$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function createdAt(date) {
    return moment(date).format('DD/MM/Y H:mm:ss');
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(document).ready(function () {
    $("[id*='count']").each(function (index, element) {
        if ($(element).val() !== "0") {
            $("#" + $(element).data('item')).append(`<small class="label pull-right bg-red" >${$(element).val()}</small>`)
        }
    })
})

function refundBasketItem(basketItem,basketItemID) {
    var table = $("#tableBasketItemRefund");
    $.post(`/admin/order/basket/${basketItemID}`)
        .then(response => {
            console.log(response);
            const data = response.data.basket;
            table.find('#refundAmountInput').removeAttr('max').val(0);
            table.find('#productName').text(basketItem.product.title);
            table.find('#totalPrice').text(data.total);
            table.find('#totalRefundableAmount').text(data.total);
            table.find('#canRefundAmount').text(data.total - data.refunded_amount);
            table.find('#basketRefundedAmount').text(data.refunded_amount);
            // table.find('#refundAmountInput').attr('max', basketItem.paid_price - basketItem.refunded_amount);
            table.find('#basketItemID').val(data.id);
            table.find('#paymentTransactionID').text(data.payment_transaction_id);
        })

}

function subCategoriesByCategoryId(categoryId) {
    $.ajax({
        url: `/admin/category/${categoryId}/sub-categories`,
        dataType: 'json',
        success: function (data) {
            var options = "";
            $("#id_sub_category_id option").not(':first').remove()
            $.each(data, function (index, element) {
                options += '<option value="' + element.id + '">' + element.title + '</option>';
            });
            $("#id_sub_category_id").append(options)
        }
    })
}

/**
 * show validation errors or any errors
 * @param response
 */
function errorMessage(response) {
    if (response.status === 400) {
        const data = JSON.parse(response.responseText);
        toastr.error(data.message)
    }
}

/**
 * show success alert message
 * @param message
 */
function successMessage(message){
    toastr.success(message)
}

/**
 *  get url param value
 * @param sParam
 * @returns {boolean|string}
 */
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};


