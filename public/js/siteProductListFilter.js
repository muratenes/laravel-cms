$(document).ready(function () {
    //PRODUCT LIST FILTER

    $("a[id*='varyant'],select[id='orderby'],#productBrandUl li").click(function () {
        $("#hdnCurPage").val(1);
        if ($(this).prop("tagName") === "A")
            $(this).hasClass('activeSubAttribute') ? $(this).removeClass('activeSubAttribute') : $(this).addClass('activeSubAttribute');
        else if ($(this).prop("tagName") === "LI") {
            $(this).children('a').hasClass('activeBrand') ? $(this).children('a').removeClass('activeBrand') : $(this).children('a').addClass('activeBrand');
        }
        setDefaultPage(productFilterbyAttrBrands())
        var itemCheck = $(this).parent("label").children("span.cr").children("i");
        if (itemCheck.hasClass("fa-check"))
            itemCheck.removeClass("fa fa-check");
        else
            itemCheck.addClass("fa fa-check");
    });
    // END PRODUCT LIST FILTER

});

//PRODUCT LIST FILTER FUNCTIONS
function productFilterbyAttrBrands() {

    return new Promise(function (resolve, reject) {
        var slug = document.location.pathname.split("/")[2];
        var curPage = $("#hdnCurPage").val();
        var perPageItem = 10; //$("select[name='ppp']").val();
        var ordering = $("select[name='orderby']").val();

        var request = $.ajax({
            url: '/productFilterWithAjax',
            dataType: 'json',
            data: {
                'slug': slug,
                'secimler[]': getAttrList(),
                'page': curPage,
                'orderBy': ordering,
                'perPageItem': perPageItem,
                'brands': getSelectedBrandList()
            },
            success: function (data) {
                $(".spTotalPage").text(data.totalPage);
                $("#hdnTotalPage").val(data.totalPage);
                $(".spTotalProduct").text(data.productTotalCount)
                $(".spRangePageItems").text((data.current_page - 1) * data.per_page + '-' + (data.per_page * data.current_page))
                bindFilterSideBar(data.returnedSubAttributes, data.filterSideBarAttr, getAttrList(), data.brands);
                urunleriListele(data.products, slug, data.campaign)
                resolve(data)
            }
        })
    })
}

// PRODUCT LIST FILTER FUNCTIONS
function bindFilterSideBar(subAttrs, filterSideBarAttr, selectedAttrList, returnedBrands) {
    // PARENT ATTRIBUTE
    $("li[id*='variantContainer']").hide();
    $(subAttrs).each(function (index, element) {
        $("#variantContainer" + element + "").show();
    });
    $("div[id*='attrFilterByID']").hide();
    $(filterSideBarAttr).each(function (ind, element) {
        $("#attrFilterByID" + element + "").show();
    })
    $("ul#productBrandUl li").hide();
    $(returnedBrands).each(function (item, element) {
        console.log(element)
        $("#brandId" + element + "").show();
    })
}


function pagination(type) {
    var curPage = parseInt($("#hdnCurPage").val())
    var totalPage = parseInt($("#hdnTotalPage").val())
    if (type === "next") {

        if (totalPage >= curPage + 1) {
            $(".spCurPage").text(String(curPage + 1))
            $("#hdnCurPage").val(String(curPage + 1))
            productFilterbyAttrBrands().then(function (data) {
                totalPage = data.totalPage;
                curPage = data.current_page;
                if (curPage <= totalPage) {
                    $("#btnPrevPage").parent('li').removeClass('disabled');
                }
                if (totalPage === curPage) {
                    $("#btnPrevPage").parent('li').removeClass('disabled');
                    $("#btnNextPage").parent('li').addClass('disabled');
                }
                if (curPage !== totalPage) { // son sayfa ise
                    $("#btnNextPage").parent('li').removeClass('disabled');
                }
                if (curPage === 1 || curPage === 0) {
                    $("#btnPrevPage").parent('li').addClass('disabled');
                }
            })
        }
    } else {
        if (curPage - 1 > 0) {
            $(".spCurPage").text(curPage - 1)
            $("#hdnCurPage").val(curPage - 1)
            productFilterbyAttrBrands().then(function (data) {
                totalPage = data.totalPage;
                curPage = parseInt($("#hdnCurPage").val());
                if (curPage <= totalPage) {
                    $("#btnPrevPage").parent('li').removeClass('disabled');
                }
                if (totalPage === curPage) {
                    $("#btnPrevPage").parent('li').removeClass('disabled');
                    $("#btnNextPage").parent('li').addClass('disabled');
                }
                if (curPage !== totalPage) { // son sayfa ise
                    $("#btnNextPage").parent('li').removeClass('disabled');
                }
                if (curPage === 1 || curPage === 0) {
                    $("#btnPrevPage").parent('li').addClass('disabled');
                }
            })
        }
    }

}

function setDefaultPage(totalPageCount) {
    var promise1 = Promise.resolve(totalPageCount);
    promise1.then(function (value) {
        $("#hdnCurPage").val(1)
        $(".spCurPage").text(1)
        $("#btnPrevPage").parent('li').addClass('disabled');
        var curPage = parseInt($("#hdnCurPage").val());
        var totalPage = value.totalPage
        if (curPage < totalPage) {
            $("#btnNextPage").parent('li').removeClass('disabled');
        } else {
            $("#btnNextPage").parent('li').addClass('disabled');
        }
    });

}



function urunleriListele(product, mainSlug) {
    var mainSlug = $("#hdnCatSlug").val();
    var ulTabOne = $("#productContainer");
    ulTabOne.html(" ");
    $(product).each(function (index, element) {
        var elementHasDetail = element.detail.length > 0 ? 1 : 0;
        let priceItemHtml = "";
        if (element.discount_price !== null)
            priceItemHtml = '<span class="old-price">' + element.price + '₺</span>\n <span class="product-price">' + element.discount_price + '₺</span>'
        else
            priceItemHtml = '<span class="product-price">' + element.price + '₺</span>\n'
        var li = '<div class="col-6 col-md-4 col-xl-3">\n' +
            '                        <div class="product-default">\n' +
            '                            <figure>\n' +
            '                                <a href="/' + element.slug + '">\n' +
            '                                    <img style="height: 200px;width: 250px" src="/uploads/products270x250/' + element.image + '">\n' +
            '                                </a>\n' +
            '                            </figure>\n' +
            '                            <div class="product-details">\n' +
            '                                <h2 class="product-title">\n' +
            '                                    <a href="/' + element.slug + '">' + (element.title.length > 25 ? String(element.title).substr(0, 25) + ".." : element.title) + '</a>\n' +
            '                                </h2>\n' +
            '                                <div class="price-box">\n' +
            '                                    ' + priceItemHtml + '' +
            '                                </div><!-- End .price-box -->\n' +
            '                                <div class="product-action">\n' +
            '                                    <a href="#" class="btn-icon-wish"><i class="icon-heart" onclick="return addToFavorites(' + element.id + ')"></i></a>\n' +
            '                                    <a class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal" onclick="return addItemToBasket(' + element.id + ',' + elementHasDetail + ')"><i class="icon-bag"></i>Sepete Ekle</a>\n' +
            '                                    <a href="/quickView/' + element.slug + '" class="btn-quickview" title="Önizleme" id="productQuickView' + element.id + '"><i class="fas fa-external-link-alt"></i></a>\n' +
            '                                </div>\n' +
            '                            </div><!-- End .product-details -->\n' +
            '                        </div>\n' +
            '                    </div>'
        ulTabOne.append(li)
    });
}

var slug = document.location.pathname.split("/")[1];


// SITE SEARCH END
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

function goToCategoryAndCityPage() {
    var selectedCategory = $("#categorySelect").val()
    var selectedCity = $("#citySelect").val()
    if (selectedCategory) {
        if (selectedCity !== "0")
            window.location.href = `/${selectedCategory}/${selectedCity}`
        else {
            window.location.href = `/${selectedCategory}`
        }
    }
}


