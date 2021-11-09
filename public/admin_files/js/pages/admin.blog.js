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
        {data: 'id', name: 'id', title: 'ID'},
        {data: 'title', name: 'title', title: 'Başlık'},
        {
            data: 'image', name: 'image', title: 'Görsel',
            render: function (data, type, row) {
                return data
                    ? `<a href="/storage/blogs/${row['image']}"><img src="/storage/blogs/${row['image']}" alt=""><i class="fa fa-photo"></i></a>`
                    : ''
            },
        },
        {
            data: 'is_active', name: 'is_active', title: 'Durum',
            render: function (data, type, row) {
                return data
                    ? `<i class="fa fa-check text-green"></i>`
                    : `<i class="fa fa-times text-danger"></i>`
            },
        },
        {
            data: 'updated_at', name: 'updated_at', title: 'Güncelleme',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'writer_id', name: 'writer_id', title: 'Yazar', visible: IS_ADMIN,
            render: function (data, type, row) {
                return row['writer']
                    ? `<a href="/admin/user/edit/${row['writer_id']}">${row['writer']['full_name']}</a>`
                    : '-'
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/blog/edit/${data}'><i class='fa fa-edit'></i></a> &nbsp;` +
               ( IS_ADMIN
                    ? `<a href="#" class="delete-item" data-id="${data}"><i class='fa fa-trash text-danger'></i></a>`
                    : '')
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});


/**
 *  delete for blog
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
