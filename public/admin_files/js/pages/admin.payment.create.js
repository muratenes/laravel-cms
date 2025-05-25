$(document).ready(function () {
    $(document).on('input', 'input[name$="[credit_cart_amount]"], input[name$="[cash_amount]"]', function () {
        alert(11);
        calculateTotalsForPayment();
    });

    $('#credit_cart_amount,#cash_amount').on('input', function () {
        calculateTotalsForPayment();
    });


    function calculateTotalsForPayment() {
        console.log('changed')
        let generalTotal = 0;
        $('.payment-amount-item').each(function () {
            const value = parseFloat($(this).val()) || 0;
            generalTotal += value;
        });

        let formatted = new Intl.NumberFormat('tr-TR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(generalTotal.toFixed(2));

        $('#total-amount-for-payment').text(formatted);
    }


    // form submit
    $(document).ready(function () {
        $('#createNewPaymentForm').on('submit', function (e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = form.serialize();

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function (response) {
                    console.log(response);
                    // Başarılı olursa yapılacaklar
                    successMessage(`${response.vendor.title} için ${response.total_amount} ₺ tutarında ödeme girildi`);

                    // 🔴 FORMU TEMİZLE
                    form.trigger('reset'); // input/select temizliği
                    $('#total-amount-for-payment').text('0.00 ₺'); // toplamı sıfırla

                    // Select2 gibi özel elementleri resetlemek gerekiyorsa:
                    $('.select2').val(null).trigger('change');

                    $('#createPaymentModal').modal('hide');
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        const errorMessage = xhr.responseJSON.message;

                        // Her bir hata mesajını al ve göster
                        let messages = [];
                        for (const field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                messages.push(errors[field].join(', '));
                            }
                        }

                        // Mesajları kullanıcıya göster (örneğin alert ile)
                        showErrorMessage(errorMessage ? errorMessage : messages.join('\n'));

                        // Veya özelleştirilmiş bir hata gösterici fonksiyon kullan:
                        // showErrorMessage(messages.join('<br>'));
                    } else {
                        showErrorMessage("Beklenmeyen bir hata oluştu.");
                    }
                }
            });
        });
    });
});
