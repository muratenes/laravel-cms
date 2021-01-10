$('#contactTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/contact/ajax'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'subject', name: 'subject'},
        {data: 'phone', name: 'phone'},
        {data: 'message', name: 'message'},
        {
            data: 'created_at', name: 'created_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});
