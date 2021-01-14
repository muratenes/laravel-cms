$(document).ready(function () {
    $("#category,#company,#state,#status").select2({})
    var table = $('#orderList').DataTable({
        processing: true,
        serverSide: true,
        order: [0, 'desc'],
        pageLength: 16,
        ajax: {
            url: '/admin/order/ajax',
            data: {
                status: $("#status").val(),
                state: $("#state").val(),
                company: $("#company").val(),
                category: $("#category").val(),
                pendingRefund: getUrlVars()["pendingRefund"],
            }
        },
        "language": {
            "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
        },
        columns: [
            {
                data: 'code', name: 'id',
                render: function (data, type, row) {
                    return `<a href="/admin/order/edit/${row.id}">${data}</a>`
                }
            },
            {data: 'full_name', name: 'full_name'},
            {
                data: 'basket.user.name', name: 'basket.user.name',
                render: function (data, type, row) {
                    return row.basket?.user
                        ? `<a href="/admin/user/edit/${row.basket.user_id}">${row.basket.user.name} ${row.basket.user.surname}</a>`
                        : '-'
                }
            },
            {
                data: 'adres', name: 'adres',
                render: function (data) {
                    return `<span title="${data}">${data.substr(0, 20)}..</span>`;
                }
            },
            {data: 'phone', name: 'phone'},
            {
                data: 'is_payment', name: 'is_payment',
                render: function (data) {
                    return data
                        ? `<i class="fa fa-check text-green"></i>`
                        : '<i class="fa fa-times text-red"></i>'
                }
            },
            {data: 'status_label', name: 'status'},
            {
                data: 'delivery_address.state.title', name: 'delivery_address.state_id',
            },
            {
                data: 'delivery_address.district.title', name: 'delivery_address.district_id',
            },
            {
                data: 'real_order_price', name: 'real_order_price',
                render: function (data, type, row) {
                    return `${row['real_order_price']} ₺`;
                }
            },
            {
                data: 'real_order_total_price', name: 'real_order_total_price',
                render: function (data, type, row) {
                    return `${row['real_order_total_price']} ₺`;
                }
            },
            {
                data: 'created_at', name: 'created_at',
                render: function (data, type, row) {
                    return createdAt(data)
                }
            }
        ]
    });
})
