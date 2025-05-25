$(document).ready(function () {
    $("#vendor_id,#company,#state,#status").select2({})
    var table = $('#orderList').DataTable({
        processing: true,
        serverSide: true,
        order: [0, 'desc'],
        pageLength: 16,
        ajax: {
            url: '/admin/order/ajax',
            data: {
                vendor_id: $("#vendor_id").val(),
            }
        },
        "language": {
            "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
        },
        columns: [
            {
                data: 'id', name: 'id',
                render: function (data, type, row) {
                    return `<a href="/admin/order/edit/${row.id}">${data}</a>`
                }
            },
            {data: 'vendor_id', name: 'vendor_id'},
            {data: 'description', name: 'description'},
            {data: 'description', name: 'description'},
            {data: 'amount', name: 'amount'},
            {data: 'amount', name: 'amount'},
        ]
    });
})
