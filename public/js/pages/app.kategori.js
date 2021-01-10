/**
  sayfalama işlemi yapar
 */
const categorySlug = $("#hdnCategorySlug").val()
const container = $('#paginationContainer');
container.pagination({
    dataSource: `/category-filter/${categorySlug}`,
    locator: 'items',
    totalNumber: $("#hdnTotalProductCount").val(),
    pageSize: 1, // per page
    ajax: {
        data: {
            orderBy: () => $("#view-option-sort").val(),
            sort: () => $("#view-option-sort option:selected").data('sort'),
        },
        beforeSend: function () {
            $(".products-list__content").html('<div class="d-flex justify-content-center" style="width: 100%"><button class="btn btn-light btn-loading btn-xl"></button></div>');
        }
    },
    alias: {
        pageNumber: 'page',
        pageSize: 'perPage'
    },
    afterPaging: function (data) {
        const itemLength = $(".products-list__item").length
        if (itemLength === 0) {
            $(".products-list__content").html('Ürün bulunamadı');
        }
    },
    //style
    classPrefix: '',
    className: 'page-item',
    ulClassName: 'pagination',
    activeClassName: 'active-page-tab',
    callback: function (data, pagination) {
        $(".products-list__content").html('')
        $(data).each(function (index, element) {
            addProductToContainer(element)
        })
    }
})

/***
 *kategori sıralama
 */
$("#view-option-sort").on('change', function () {
    const order = $("#view-option-sort").val()
    const sort = $("#view-option-sort option:selected").data('sort')
    container.pagination('go', 1)
});

function getSortParams() {
    const order = $("#view-option-sort").val()
    const sort = $("#view-option-sort option:selected").data('sort')
    console.log('aa', order, sort)
    return `${order},${sort}`;
}


function addProductToContainer(product) {
    $(".products-list__content").append(
        `<div class="products-list__item">
            <div class="product-card">
                <div class="product-card__actions-list">
                    <button class="product-card__action product-card__action--quickview" type="button" aria-label="Hızlı Görünüm" data-id="${product.id}">
                        <svg width="16" height="16">
                            <path d="M14,15h-4v-2h3v-3h2v4C15,14.6,14.6,15,14,15z M13,3h-3V1h4c0.6,0,1,0.4,1,1v4h-2V3z M6,3H3v3H1V2c0-0.6,0.4-1,1-1h4V3zM3,13h3v2H2c-0.6,0-1-0.4-1-1v-4h2V13z"></path>
                        </svg>
                    </button>
                    <button class="product-card__action product-card__action--wishlist" type="button" aria-label="İstek listesine ekle" onclick="addToFavorites(${product.id})">
                        <svg width="16" height="16">
                            <path d="M13.9,8.4l-5.4,5.4c-0.3,0.3-0.7,0.3-1,0L2.1,8.4c-1.5-1.5-1.5-3.8,0-5.3C2.8,2.4,3.8,2,4.8,2s1.9,0.4,2.6,1.1L8,3.7l0.6-0.6C9.3,2.4,10.3,2,11.3,2c1,0,1.9,0.4,2.6,1.1C15.4,4.6,15.4,6.9,13.9,8.4z"></path>
                        </svg>
                    </button>
                </div>
                <div class="product-card__image">
                    <div class="image image--type--product"><a href="/${product.slug}" class="image__body"><img class="image__tag" src="/storage/products/${product.image}" alt=""></a></div>
                </div>
                <div class="product-card__info">
                    <div class="product-card__meta"><span class="product-card__meta-title">Stok Kodu:</span> ${product.code}</div>
                    <div class="product-card__name">
                        <div>
                            <div class="product-card__badges">${product.tl_discount_price ? ' <div class="tag-badge tag-badge--sale">İndirimli</div>' : ''}</div>
                            <a href="/${product.slug}">${product.title}</a></div>
                    </div>

                    <div class="product-card__features">
                        <ul>${product.spot}</ul>
                    </div>
                </div>
                <div class="product-card__footer">
                    <div class="product-card__prices">
                        <div class="product-card__price product-card__price--current">₺ ${product.tl_discount_price ? product.tl_discount_price : product.tl_price}</div>
                        ${
            product.tl_discount_price ? `<div class="product-card__price product-card__price--old">₺ ${product.tl_price}</div>` : ''
        }
                    </div>
                    <button class="product-card__addtocart-icon addItemToBasket" type="button" aria-label="Sepete ekle" data-id="${product.id}">
                        <svg width="20" height="20">
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="15" cy="17" r="2"></circle>
                            <path d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6
\tV1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4
\tC17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z"></path>
                        </svg>
                    </button>
                    <button class="product-card__addtocart-full addItemToBasket" type="button" data-id="${product.id}">Sepete Ekle</button>
                    <button class="product-card__wishlist" type="button" onclick="addToFavorites(${product.id})">
                        <svg width="16" height="16">
                            <path d="M13.9,8.4l-5.4,5.4c-0.3,0.3-0.7,0.3-1,0L2.1,8.4c-1.5-1.5-1.5-3.8,0-5.3C2.8,2.4,3.8,2,4.8,2s1.9,0.4,2.6,1.1L8,3.7
\tl0.6-0.6C9.3,2.4,10.3,2,11.3,2c1,0,1.9,0.4,2.6,1.1C15.4,4.6,15.4,6.9,13.9,8.4z"></path>
                        </svg>
                        <span>İstek Listesine ekle</span></button>
                </div>
            </div>
        </div>`
    )
}



