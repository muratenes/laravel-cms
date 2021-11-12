$('#tableBanner').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/banners'
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id', title: 'ID'},
        {data: 'title', name: 'title', title: 'Başlık'},
        {data: 'sub_title', name: 'sub_title', title: 'Alt Başlık'},
        {
            data: 'image', name: 'image', title: 'Görsel',
            render: function (data, type, row) {
                return data
                    ? `<a href="/storage/banners/${row['image']}"><i class="fa fa-photo"></i></a>`
                    : ''
            },
        },
        {
            data: 'lang', name: 'lang',title: 'Dil',visible : CONSTANTS.MULTI_LANGUAGE,
            render: function (data, type, row) {
                return `<img src="${row['lang_icon']}" alt="">`
            }
        },
        {data: 'link', name: 'link', title: 'Link'},
        {
            data: 'active', name: 'active', title: 'Durum',
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
            data: 'created_at', name: 'updated_at', title: 'Oluşturma',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'id', name: 'id', orderable: false,
            render: function (data) {
                return `<a href='/admin/banner/edit/${data}'><i class='fa fa-edit'></i></a> &nbsp;` +
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
$('#tableBanner').on('click', '.delete-item', function () {
    if (confirm('Silmek istediğine emin misin ? ')) {
        // $(this).parent().parent().remove()
        const id = $(this).data('id')
        const self = this;
        console.log(id);
        $.ajax({
            url: `/admin/banner/${id}`,
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
