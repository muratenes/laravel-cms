$(function () {
    $("#paymentForm").validate({
        errorClass: "ui-state-error",
        rules: {
            cardNumber: {
                required: true,
                minlength: 19
            },
            holderName: {
                required: true,
                minlength: 4
            },
            cvv: {
                required: true,
                minlength: 3,
                maxlength: 3
            },
            checkoutTerms: "required",
            cardExpireDateMonth: "required",
            cardExpireDateYear: "required",
            // invoice address files
            title: {
                required: function () {
                    return isCheckedDiffAddress();
                },
                minlength: 2,
                maxlength: 50
            },
            phone: {
                required: function () {
                    return isCheckedDiffAddress()
                },
                maxlength: 20
            },
            name: {
                required: function () {
                    return isCheckedDiffAddress()
                },
                minlength: 3,
                maxlength: 50
            },
            surname: {
                required: function () {
                    return isCheckedDiffAddress()
                },
                minlength: 2,
                maxlength: 50
            },
            state_id: {
                required: function () {
                    return isCheckedDiffAddress()
                }
            },
            district_id: {
                required: function () {
                    return isCheckedDiffAddress()
                }
            },
            adres: {
                required: function () {
                    return isCheckedDiffAddress()
                },
                minlength: 10,
                maxlength: 255
            },
            email: {
                required: function () {
                    return isCheckedDiffAddress()
                },
                email: true,
                maxlength: 50
            },
            order_note: {
                maxlength: 50
            }

        },
        messages: {
            cardNumber: {
                required: "Kart Numarası Giriniz"
            },
            holderName: {
                required: "Kart üzerindeki isim gereklidir"
            },
            cvv: {
                required: "Bu alan gereklidir."
            },
            checkoutTerms: "Mesafeli satış sözleşmesini kabul etmeniz gerekiyor."
        },
        errorPlacement: function (error, element) {
            if (element.is(":checkbox")) {
                console.log('checkbox')
                error.appendTo(element.parent('span').parent('span'));
                // $("<br>").appendTo(element.parent().parent().find("label:first"));
                // error.appendTo(element.parent().parent().find("label:first"));
            } else {
                error.appendTo(element.parent());
            }
        },
        submitHandler: function (form) {
            console.log('submit')
            $('#cardNumber,#cvv,#address-phone').unmask();
            form.submit();
        }
    });
});

function isCheckedDiffAddress() {
    return $('#checkout-different-address').is(':checked')
}


/**
 *  fatura adresim farklı ?
 */
$('#checkout-different-address').change(function () {
    $("#differentInvoiceAddress").toggle()
});

function getInstallmentDetails(totalPrice) {
    let creditCartNumber = $("#cardNumber").val();
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

