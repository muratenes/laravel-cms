
$('#vendorTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/vendors/ajax'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {
            data: 'user', name: 'user',
            render: function (data, type, row) {
                return `${row['user']['name']} ${row['user']['surname']}`
            }
        },
        {
            data: 'phone', name: 'phone',
            render: function (data, type, row) {
                return data
            }
        },
        {
            data: 'created_at', name: 'created_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'is_active', name: 'is_active',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/vendors/edit/${data}'><i class='fa fa-edit'></i></a> &nbsp;`
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

/**
 * yerel/uzak Hizmeti siler
 */
$('#userTable').on('click', '.delete-item', function () {
    if (confirm('Silmek istediğine emin misin ? ')) {
        // $(this).parent().parent().remove()
        const id = $(this).data('id')
        const self = this;
        $.ajax({
            url: '/admin/user/' + id + '',
            dataType: 'json',
            method: 'DELETE',
            success: function (data) {
                $(self).parent().parent().css('background-color', 'red')
                    .fadeOut(600, function () {
                        this.remove();
                    });
            },
            error: function (xhr, error) {
                console.log(xhr)
                errorMessage(xhr)
                console.log(error)
            }
        })
    }
});
