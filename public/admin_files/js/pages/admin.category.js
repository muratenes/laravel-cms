$('#tableCategories').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/categories',
        data: {
            type: getUrlParameter('type')
        }
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id', title: 'ID'},
        {data: 'title', name: 'title', title: 'Başlık'},
        {
            data: 'parent_category_id', name: 'parent_category_id', title: 'Üst Kategori',
            render: function (data, type, row) {
                return row['parent_category']
                    ? `<a href="/admin/category/${data}/">${row['parent_category']['title']}</a>`
                    : ''
            },
        },
        {data: 'type_label', name: 'categorizable_type', title: 'Tür'},
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
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/category/${data}'><i class='fa fa-edit'></i></a> &nbsp;` +
                    `<a href="#" class="delete-item" data-id="${data}"><i class='fa fa-trash text-danger'></i></a>`

            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

/**
 *  delete for category
 */
$('#tableCategories').on('click', '.delete-item', function () {
    if (confirm('Silmek istediğine emin misin ? ')) {
        const id = $(this).data('id')
        const self = this;
        $.ajax({
            url: `/admin/category/${id}`,
            dataType: 'json',
            method: 'DELETE',
            success: function (data) {
                $(self).parent().parent().css('background-color', 'red')
                    .fadeOut(600, function () {
                        this.remove();
                    });
            },
            error: function (xhr, error) {
                errorMessage(xhr)
            }
        })
    }
});
