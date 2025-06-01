$(document).ready(function () {
    $("#vendor_id,#company,#state,#status").select2({})
    var table = $('#orderList').DataTable({
        processing: true,
        serverSide: true,
        order: [0, 'desc'],
        pageLength: 10,
        ajax: {
            url: '/admin/order/ajax',
            data: {
                vendor_id: $("#vendorIdFilter").val(),
                start_date: $("#startDateFilter").val(),
                end_date: $("#endDateFilter").val(),
            }
        },
        "language": {
            "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: function (data, type, row) {
                    return `#<a href="/admin/order/edit/${row.id}">${data}</a>`
                }
            },
            {
                data: 'vendor_id', name: 'vendor_id',
                render: function (data, type, row) {
                    return `<a href="/admin/vendors/edit/${row.id}">${row['vendor']['title']}</a>`
                }
            },
            {data: 'description', name: 'description'},
            {data: 'due_date', name: 'due_date'},
            {
                data: 'transactions',
                name: 'transactions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if (!data || data.length === 0) {
                        return '<span class="text-muted">Ürün yok</span>';
                    }

                    // Her transaction için ürün bilgilerini derle
                    let html = '<ul class="list-unstyled m-0">';
                    data.forEach(tx => {
                        html += `<li>${tx.product.name} (${tx.per_price} ₺) * ${tx.quantity} adet = ${tx.amount} ₺</li>`;
                    });
                    html += '</ul>';
                    return html;
                }
            },
            {
                data: 'amount', name: 'amount',
                render: function (data, type, row) {
                    return `${data} ₺`
                }
            },
            {
                data: 'created_at', name: 'created_at',
                render: function (data, type, row) {
                    return createdAt(data)
                }
            },
        ]
    });
})
