$(document).ready(function () {
    $("#category_filter,#company_filter,#brand_filter").select2({})
    var table = $('#productList').DataTable({
        processing: true,
        serverSide: true,
        order: [0, 'desc'],
        pageLength: 16,
        ajax: {
            url: '/admin/product/ajax',
            data: {
                category: $("#category_filter").val(),
                company: $("#company_filter").val(),
                brand: $("#brand_filter").val(),
            }
        },
        "language": {
            "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
        },
        columns: [
            {data: 'id', name: 'id'},
            {
                data: 'name', name: 'name',
                render: function (data, type, row) {
                    return `<a href="/admin/product/edit/${row.id}">${data}</a>`
                }
            },
            {
                data: 'purchase_price', name: 'purchase_price',
                render: function (data, type, row) {
                    return `${data} ₺`
                }
            },
            {
                data: 'price', name: 'price',
                render: function (data, type, row) {
                    return `${data} ₺`
                }
            },
            {
                data: 'vendors', name: 'vendors',
                render: function (data, type, row) {
                    return data.length > 0
                        ? data.length
                        : 0
                }
            },
            {
                data: 'stock_follow', name: 'stock_follow',
                render: function (data, type, row) {
                    return data === 0
                        ? "Takip edilmiyor"
                        : row['stock']
                }
            },
            {
                data: 'updated_at', name: 'updated_at',
                render: function (data, type, row) {
                    return createdAt(data)
                }
            },
            {
                data: 'id', name: 'id',
                render: function (data, type, row) {
                    return `<a href="/admin/product/edit/${row.id}"><i class="fa fa-edit"></i></a>`
                }
            }
        ]
    });
})
