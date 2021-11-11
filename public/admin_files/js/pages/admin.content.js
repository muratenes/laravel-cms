$('#contentManagement').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/admin/tables/contents',
    },
    "language": {
        "url": "/admin_files/plugins/jquery-datatable/language-tr.json"
    },
    columns: [
        {data: 'id', name: 'id',title: 'ID'},
        {data: 'title', name: 'title',title: 'Başlık' },
        {
            data: 'image', name: 'image', title: 'Görsel',
            render: function (data, type, row) {
                return data
                    ? `<a href="/storage/contents/${row['image']}"><img src="/storage/contents/${row['image']}" alt=""><i class="fa fa-photo"></i></a>`
                    : ''
            },
        },
        {
            data: 'updated_at', name: 'updated_at',title: 'Son Güncelleme',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'created_at', name: 'created_at', title: 'Oluşturma',
            render: function (data, type, row) {
                return createdAt(data)
            }
        },
        {
            data: 'lang', name: 'lang',title: 'Dil',visible : MULTI_LANGUAGE,
            render: function (data, type, row) {
                return data
            }
        },
        {
            data: 'active', name: 'active',title : 'Durum',
            render: function (data, type, row) {
                return data ? "<i class='fa fa-check text-green'></i>" : "<i class='fa fa-times'></i>"
            }
        },
        {
            data: 'id', name: 'id', orderable: false,title : '#',
            render: function (data) {
                return `<a href='/admin/content/${data}'><i class='fa fa-edit'></i></a> &nbsp;` +
                    `<a href="#" class="delete-item" data-id="${data}"><i class='fa fa-trash'></i></a>`
            }
        }
    ],
    order: [0, 'desc'],
    pageLength: 10
});

/**
 * yerel/uzak Hizmeti siler
 */
$('#contentManagement').on('click', '.delete-item', function () {
    if (confirm('Silmek istediğine emin misin ? ')) {
        // $(this).parent().parent().remove()
        const id = $(this).data('id')
        const self = this;
        $.ajax({
            url: '/admin/content/' + id + '',
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
