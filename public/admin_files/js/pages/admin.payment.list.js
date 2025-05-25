$(document).ready(function () {
    $("#vendor_id,#company,#state,#status").select2({width:'100%'})
    var table = $('#paymentList').DataTable({
        processing: true,
        serverSide: true,
        order: [0, 'desc'],
        pageLength: 16,
        ajax: {
            url: '/admin/payments/ajax',
            data: {
                vendor_id: $("#vendor_id_filter").val(),
            }
        },
        "language": {
            "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: function (data, type, row) {
                    return `#<a href="/admin/payments/edit/${row.id}">${data}</a>`
                }
            },
            {
                data: 'vendor_id', name: 'vendor_id',
                render: function (data, type, row) {
                    return `<a href="/admin/vendors/edit/${row.id}">${row['vendor']['title']}</a>`
                }
            },
            {
                data: 'cash_amount', name: 'cash_amount',
                render: function (data, type, row) {
                    return `${data} ₺`
                }
            },
            {
                data: 'credit_cart_amount', name: 'credit_cart_amount',
                render: function (data, type, row) {
                    return `${data} ₺`
                }
            },
            {
                data: 'amount', name: 'amount',
                render: function (data, type, row) {
                    return `${data} ₺`
                }
            },
            {data: 'due_date', name: 'due_date'},
            {data: 'description', name: 'description'},
            {
                data: 'created_at', name: 'created_at',
                render: function (data, type, row) {
                    return createdAt(data)
                }
            }
        ]
    });
})
