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
                data: 'title', name: 'title',
                render: function (data, type, row) {
                    return `<a href="/admin/product/edit/${row.id}">${data}</a>`
                }
            },
            {
                data: 'id', name: 'id', searchable: false, orderable: false,
                render: function (data, type, row) {
                    let categoriesHtml = '';
                    $(row.categories).each(function (index, item) {
                        categoriesHtml += `<a href="/admin/category/edit/${item.id}">${item.title}</a>,`
                    });
                    return categoriesHtml;
                },
                visible: $("#useCategory").val() == 1 && $("#useMultipleCategory").val() == 1
            },
            {
                data: 'parent_category_id', name: 'parent_category_id',
                render: function (data, type, row) {
                    return data
                        ? `<a href="/admin/category/edit/${data}">${row.parent_category.title}</a>`
                        : ``
                },
                visible: $("#useCategory").val() == 1 && $("#useMultipleCategory").val() == 0
            },
            {
                data: 'sub_category_id', name: 'sub_category_id',
                render: function (data, type, row) {
                    return data
                        ? `<a href="/admin/category/edit/${data}">${row.sub_category.title}</a>`
                        : ``
                },
                visible: $("#useCategory").val() == 1 && $("#useMultipleCategory").val() == 0
            },
            {
                data: 'slug', name: 'slug',
                render: function (data, type, row) {
                    const prefix = $("#productDetailPrefix").val().replaceAll('_', '')
                    return `<a href="${prefix}${data}">${data.substr(0, 7)}.. <i class="fa fa-external-link"></i></a>`
                }
            },
            {
                data: 'company_id', name: 'company_id',
                render: function (data, type, row) {
                    return data
                        ? `<a target="_blank" href="/admin/product/company/edit/${data}">${row.company.title}</a>`
                        : ''
                },
                visible: $("#useCompany").val() == 1
            },
            {
                data: 'brand_id', name: 'brand_id',
                render: function (data, type, row) {
                    return data
                        ? `<a target="_blank" href="/admin/product/brands/edit/${data}">${row.brand.title}</a>`
                        : ''
                },
                visible: $("#useBrand").val() == 1
            },
            {
                data: 'qty',
                name: 'qty',
                render: function (data, type, row) {
                    return `<span class="${data > 10 ? 'text-green' : 'text-danger'}">${data}</span>`
                },
                visible: $("#useQty").val() == 1
            },
            {
                data: 'tl_price', name: 'tl_price',
                render: function (data) {
                    return `${data} ₺`
                },
                visible: $("#usePrice").val() == 1
            },
            {
                data: 'tl_discount_price', name: 'tl_discount_price', render: function (data) {
                    return data ? `${data} ₺` : '-'
                },
                visible: $("#usePrice").val() == 1
            },
            {
                data: 'image', name: 'image',
                render: function (data) {
                    const productImagePrefix = $("#productImagePrefix").val()
                    return data
                        ? `<a target="_blank" href="${productImagePrefix}${data}">${data}</a>`
                        : ''
                },
                visible: $("#useImage").val() == 1
            },
            {
                data: 'active', name: 'active',
                render: function (data) {
                    return data
                        ? `<i class="fa fa-check text-green"></i>`
                        : '<i class="fa fa-times text-red"></i>'
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
