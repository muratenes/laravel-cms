$(document).ready(function () {
    $('#add-order-product-row').on('click', function () {

        // validations
        const selectedCompany = $('#createNewOrderContainer #vendor_id').val();
        if (!selectedCompany) {
            showErrorMessage("Lütfen esnaf seçiniz")
            return false;
        }

        const selectedProduct = $('#createNewOrderContainer #productId').val();
        if (!selectedProduct) {
            showErrorMessage("Lütfen ürün seçiniz")
            return false;
        }

        /// add product
        const rowCount = $('#order-rows-body tr').length;
        console.log(rowCount);
        const newRowHtml = $('.template-order-product-row').html();
        const $newRow = $(newRowHtml);
        $newRow.find('select[name="items[][product_id]"]').attr('name', `items[${rowCount}][product_id]`);
        $newRow.find('input[name="items[][quantity]"]').attr('name', `items[${rowCount}][quantity]`);
        $newRow.find('input[name="items[][per_price]"]').attr('name', `items[${rowCount}][per_price]`);

        var productPrice = getProductPrice(selectedProduct, selectedCompany, window.appSettings.products)

        $newRow.find('.productPrice').prop('value', productPrice);

        $newRow.find('.productSelect')
            .val(selectedProduct)
            .trigger('change');

        $newRow.find('.line-total')
            .text(productPrice);

        $('#order-rows-body').append($newRow);
    });

    // Quantity veya Price değişince toplamı hesapla
    // input event
    $(document).on('input', 'input[name$="[quantity]"], input[name$="[per_price]"]', function () {
        calculateTotals();
    });

    // click event for button with class X
    $(document).on('click', '.remove-row,#add-order-product-row', function () {
        calculateTotals();
    });


    function getProductPrice(productId, vendorId, products) {
        const product = products.find(p => p.id === parseInt(productId));
        if (!product) return null;

        // Vendor'a özel fiyat var mı?
        const vendorData = product.vendors?.find(v => v.id === parseInt(vendorId));
        if (vendorData && vendorData.pivot?.price) {
            return vendorData.pivot.price;
        }

        // Yoksa ürünün genel fiyatını döndür
        return product.price;
    }

    function calculateTotals() {
        $('.line-total').each(function () {
            const $row = $(this).closest('tr');
            const quantity = parseFloat($row.find('input[name$="[quantity]"]').val()) || 0;
            const price = parseFloat($row.find('input[name$="[per_price]"]').val()) || 0;
            const total = quantity * price;

            $(this).text(`${total.toFixed(2)}`);
        });

        let generalTotal = 0;
        $('.line-total').each(function () {
            const value = parseFloat($(this).text()) || 0;
            generalTotal += value;
        });

        $('#total-amount').text(`${generalTotal.toFixed(2)}`);
    }


    // Satır sil
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '#createNewOrderContainer #vendor_id', function () {
        $("#order-product-table .remove-row").trigger('click');
    })

    // form submit
    $(document).ready(function () {
        $('#createNewOrderForm').on('submit', function (e) {
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
                    // Başarılı olursa yapılacaklar
                    successMessage('Sipariş başarıyla oluşturuldu');

                    // 🔴 FORMU TEMİZLE
                    form.trigger('reset'); // input/select temizliği
                    $('#order-rows-body').empty(); // ürün satırlarını temizle
                    $('#total-amount').text('0.00 ₺'); // toplamı sıfırla

                    // Select2 gibi özel elementleri resetlemek gerekiyorsa:
                    $('.select2').val(null).trigger('change');
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
