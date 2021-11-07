$('#tableBlog').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/blogs'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {
            data: 'image', name: 'image',
            render: function (data, type, row) {
                return data
                    ? `<a><img src="/storage/blogs/${row['image']}" alt=""><i class="fa fa-photo"></i></a>`
                    : ''
            },
        },
        {
            data: 'active', name: 'active',
            render: function (data, type, row) {
                return data
                    ? `<i class="fa fa-check text-green"></i>`
                    : `<i class="fa fa-times text-danger"></i>`
            },
        },
        {
            data: 'created_at', name: 'created_at',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/blog/edit/${data}'><i class='fa fa-edit'></i></a> &nbsp;` +
                    `<a href="#" class="delete-item" data-id="${data}"><i class='fa fa-trash text-danger'></i></a>`
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});


/**
 *  delete for user
 */
$('#tableBlog').on('click', '.delete-item', function () {
    if (confirm('Silmek istediğine emin misin ? ')) {
        // $(this).parent().parent().remove()
        const id = $(this).data('id')
        const self = this;
        console.log(id);
        $.ajax({
            url: `/admin/blog/${id}`,
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
