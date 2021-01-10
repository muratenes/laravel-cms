$(document).ready(function () {
    // if ($("#pageTrigger").val() == "False") {
    //     productFilterbyAttrBrandsOnCampaigns();
    //     $(this).val("True");
    // }

    //PRODUCT LIST FILTER

    $("a[id*='varyant'],select[id='orderby'],#productBrandUl li").click(function () {
        $("#hdnCurPage").val(1);
        if ($(this).prop("tagName") === "A")
            $(this).hasClass('activeSubAttribute') ? $(this).removeClass('activeSubAttribute') : $(this).addClass('activeSubAttribute');
        else if ($(this).prop("tagName") === "LI") {
            $(this).children('a').hasClass('activeBrand') ? $(this).children('a').removeClass('activeBrand') : $(this).children('a').addClass('activeBrand');
        }
        setDefaultPage(productFilterbyAttrBrandsOnCampaigns())
        var itemCheck = $(this).parent("label").children("span.cr").children("i");
        if (itemCheck.hasClass("fa-check"))
            itemCheck.removeClass("fa fa-check");
        else
            itemCheck.addClass("fa fa-check");
    });
    // END PRODUCT LIST FILTER

});

//PRODUCT LIST FILTER FUNCTIONS
function productFilterbyAttrBrandsOnCampaigns() {

    return new Promise(function (resolve, reject) {
        var slug = document.location.pathname.split("/")[2];
        var categorySlug = $("#hdnCategorySlug").val();
        var curPage = $("#hdnCurPage").val();
        var perPageItem = 10; //$("select[name='ppp']").val();
        var ordering = $("select[name='orderby']").val();

        var request = $.ajax({
            url: '/campaignsFilterWithAjax',
            dataType: 'json',
            data: {
                'slug': slug,
                'secimler[]': getAttrList(),
                'page': curPage,
                'category': categorySlug,
                'orderBy': ordering,
                'perPageItem': perPageItem,
                'brands': getSelectedBrandList()
            },
            success: function (data) {
                $(".spTotalPage").text(data.totalPage);
                $("#hdnTotalPage").val(data.totalPage);
                $(".spTotalProduct").text(data.productTotalCount)
                $(".spRangePageItems").text((data.products.current_page - 1) * data.products.per_page + '-' + (data.products.per_page * data.products.current_page))
                bindFilterSideBar(data.returnedSubAttributes, data.filterSideBarAttr, getAttrList(), data.brands);
                urunleriListele(data.products.data, slug, data.campaign)
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
    $("#brandWidgetContainer").show()
    $(returnedBrands).each(function (item, element) {
        $("#brandId" + element.id + "").show();
    })

}


function pagination(type) {
    var curPage = parseInt($("#hdnCurPage").val())
    var totalPage = parseInt($("#hdnTotalPage").val())
    if (type === "next") {

        if (totalPage >= curPage + 1) {
            $(".spCurPage").text(String(curPage + 1))
            $("#hdnCurPage").val(String(curPage + 1))
            productFilterbyAttrBrandsOnCampaigns().then(function (data) {
                totalPage = data.totalPage;
                curPage = data.products.current_page;
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
            productFilterbyAttrBrandsOnCampaigns().then(function (data) {
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
    // console.log(totalPageCount)
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


function getAttrList() {
    var attrList = new Array();
    var index = 0;

    $($("div[id*='attrFilterByID']")).each(function () {
        var itemList = [];
        jQuery(this).find(".activeSubAttribute").each(function () {
            itemList.push(parseInt($(this).attr('value')));
        });
        attrList[index] = new Array(itemList);
        index++;
    });
    return attrList;
}

function urunleriListele(product, mainSlug, campaign) {
    var mainSlug = $("#hdnCatSlug").val();
    var ulTabOne = $("#productContainer");
    ulTabOne.html(" ");
    $(product).each(function (index, element) {
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
            '                                    <a class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal" onclick="return addItemToBasket(' + element.id + ',' + element.detail + ')"><i class="icon-bag"></i>Sepete Ekle</a>\n' +
            '                                    <a href="/quickView/' + element.slug + '" class="btn-quickview" title="Önizleme"><i class="fas fa-external-link-alt"></i></a>\n' +
            '                                </div>\n' +
            '                            </div><!-- End .product-details -->\n' +
            '                        </div>\n' +
            '                    </div>'
        ulTabOne.append(li)
    });
}

var slug = document.location.pathname.split("/")[1];


