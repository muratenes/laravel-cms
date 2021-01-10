function getAndFillSubAttributeByAttributeID(attributeId, JqueryFilledHtmlItem) {
    $.ajax({
        url: "/admin/product/attributes/get-sub-attributes-by-attribute-id/" + attributeId + "",
        dataType: 'json',
        success: function (data) {
            $(JqueryFilledHtmlItem).children().remove();
            var options = "";
            $.each(data.data.sub_attributes, function (index, element) {
                options += '<option value="' + element.id + '">' + element.title + '</option>';
            });
            $(JqueryFilledHtmlItem).append(options);
        }
    });
}

function addToNewProperty(key = '', value = '') {
    var containerOzellikler = $("#containerOzellikler");
    var totalAttrCount = $(".itemOzellikler").last().data('index') || 0
    var currentAttrCount = totalAttrCount + 1;
    var appendHtml =
        `<div class="box-body itemOzellikler"  id="productPropertyContainer${totalAttrCount}" data-index="${currentAttrCount}">\n` +
        '     <div class="form-group col-md-6">\n' +
        '       <label>Başlık</label>\n' +
        '          <input type="text" class="form-control" name="properties[' + currentAttrCount + '][key]" placeholder="Özellik Adı" value="' + key + '">\n' +
        '           </div>\n' +
        '           <div class="form-group col-md-5 ">\n' +
        '       <label>Açıklama</label>\n' +
        '     <input type="text" class="form-control" name="properties[' + currentAttrCount + '][value]" placeholder="Açıklama" value="' + value + '">\n' +
        '   </div>\n' +
        ' <div class="form-group col-md-1">\n' +
        '                                            <label>Sil</label><br>\n' +
        '                                            <a onclick="deleteProductProperties(' + totalAttrCount + ')"><i class="fa fa-trash"></i></a>\n' +
        '</div>'
    ' </div>'
    containerOzellikler.append(appendHtml);
}

function addToNewPropertyForLanguage(language, key = '', value = '') {
    var containerOzellikler = $("#product-feature-container-" + language);
    var totalAttrCount = $(".product-item-language-" + language).last().data('index') || 0;
    var currentAttrCount = totalAttrCount + 1;
    var appendHtml =
        `<div class="box-body product-item-language-${language}"  id="product-property-container-${language}-${currentAttrCount}" data-index="${currentAttrCount}">\n` +
        '     <div class="form-group col-md-6">\n' +
        '       <label>Başlık</label>\n' +
        '          <input type="text" class="form-control" name="' + language + '_properties[' + currentAttrCount + '][key]" placeholder="Özellik Adı" value="' + key + '">\n' +
        '           </div>\n' +
        '           <div class="form-group col-md-5 ">\n' +
        '       <label>Açıklama</label>\n' +
        '     <input type="text" class="form-control" name="' + language + '_properties[' + currentAttrCount + '][value]" placeholder="Açıklama" value="' + value + '">\n' +
        '   </div>\n' +
        ' <div class="form-group col-md-1">\n' +
        '       <label>Sil</label><br>\n' +
        ` <a onclick="deleteProductPropertiesByLanguage(${currentAttrCount},${language})"><i class="fa fa-trash"></i></a>\n` +
        '</div>'
    ' </div>'
    containerOzellikler.append(appendHtml);
}


function addNewProductDetail() {
    //productDetailAttribute sayısını getir
    let $productDetailTotalCount = isNaN($(".productDetailAttribute").last().attr("data-index")) ? 0 : parseInt($(".productDetailAttribute").last().attr("data-index")) + 1;
    let $productDetailAttributeContainer = $("#productDetailAttributeContainer");
    let $detailItem =
        '<div class="form-row row productDetailAttribute" data-index="' + $productDetailTotalCount + '">\n' +
        '  <div class="form-group col-md-5">\n' +
        '    <label for="exampleInputEmail1">Ürün Özellik Adı</label>\n' +
        '    <select name="attribute' + $productDetailTotalCount + '" id="productAttribute' + $productDetailTotalCount + '" class="form-control">\n' +
        '    </select>\n' +
        '   </div>\n' +
        '  <div class="form-group col-md-5">\n' +
        '    <label for="exampleInputEmail1">Alt Özellikler</label>\n' +
        '      <select name="subAttributes' + $productDetailTotalCount + '[]" id="subAttributes' + $productDetailTotalCount + '" class="form-control" multiple required>\n' +
        '\n' +
        '     </select>\n' +
        '   </div>\n' +
        '   <div class="form-group col-md-2">\n' +
        '                                                <label for="exampleInputEmail1">&nbsp;</label><br>\n' +
        '                                                <a href="javascript:void(0);" onclick="deleteProductDetailFromForm(' + $productDetailTotalCount + ')"><i\n' +
        '                                                        class="fa fa-trash text-red"></i></a>\n' +
        '  </div>' +
        '    </div>';
    $productDetailAttributeContainer.append($detailItem);
    $("#productAttribute" + $productDetailTotalCount + "").attr('onchange', 'getAndFillSubAttributeByAttributeID(this.value, "#subAttributes' + $productDetailTotalCount + '")').select2({
        placeholder: 'Lütfen kategori seçiniz'
    });
    $("#subAttributes" + $productDetailTotalCount + "").select2({
        placeholder: 'Lütfen Alt Özellikler seçiniz'
    });
    getAllProductDetailAttributesAndFillItem("#productAttribute" + $productDetailTotalCount)

}


function getAllProductDetailAttributesAndFillItem(JqueryFilledHtmlItem) {
    $.ajax({
        url: "/admin/product/attributes/get-all-product-attributes",
        dataType: 'json',
        success: function (data) {
            $(JqueryFilledHtmlItem).children().remove();
            var options = "<option value=''>Seçiniz</option>";
            $.each(data.data.attributes, function (index, element) {
                options += '<option value="' + element.id + '">' + element.title + '</option>';
            });
            $(JqueryFilledHtmlItem).append(options);
        }
    })
}

function deleteProductDetailFromDB($detailId, $index) {
    if (confirm('Ürünü ait özellikler ve bu özellikle ilgili bütün varyantlar veritabanından silinsin mi ?')) {
        $.ajax({
            url: "/admin/product/deleteProductDetailById/" + $detailId + "",
            dataType: 'json',
            success: function (data) {
                if (data === true) {
                    deleteProductDetailFromForm($index);
                } else {
                    alert(data);
                }
            }
        })
    }
}

function deleteProductVariantFromDB(variantId, index) {
    if (confirm('ürüne ait varyant silinecek onaylıyor musunuz ?')) {
        $.ajax({
            url: "/admin/product/deleteProductVariant/" + variantId + "",
            dataType: 'json',
            success: function (data) {
                if (data == true) {
                    deleteProductVariantItemFromForm(index);
                } else {
                    alert(data);
                }
            }, error: function (xhr, options) {
                alert(xhr.responseText + options);
            }
        })

    }

}

function deleteProductVariantItemFromForm(index) {
    $(".productVariantItem[data-index=" + index + "]").fadeOut(300, function () {
        this.remove();
    });
}

function deleteProductDetailFromForm($index) {
    $("#productDetailAttributeContainer .productDetailAttribute[data-index=" + $index + "]").fadeOut(300, function () {
        this.remove();
    });
}

function addNewProductVariantItem($productId) {
    const currencies = JSON.parse($('meta[name=currencies]').attr('content'));
    console.log(currencies);
    let currencyOptions = ''
    $.each(currencies, function (index, currency) {
        console.log(index, currency[1])
        currencyOptions += `<option value="${currency[0]}">${currency[1]}</option>`;
    });
    console.log(currencyOptions);
    let productVariantTotalCount = isNaN($(".productVariantItem").last().attr("data-index")) ? 0 : parseInt($(".productVariantItem").last().attr("data-index")) + 1;
    let $productVariantAttributeContainer = $("#productVariantContainer");
    $.ajax({
        url: "/admin/product/getProductDetailWithSubAttributes/" + $productId + "",
        dataType: 'json',
        success: function (data) {
            let variantItemAttributes = "";
            $.each(data.detail, function (index, element) {
                let variantItemAttributeSubAttributes = "";
                $.each(element.sub_details, function (index2, element2) {
                    variantItemAttributeSubAttributes += '<option value="' + element2.sub_attribute + '">' + element2.parent_sub_attribute.title + '</option>'
                });
                variantItemAttributes +=
                    '<div class="col-md-1">\n' +
                    '  <td><label for="">' + element.parent_title + '</label>\n' +
                    '    <!-- variant attribute id below hidden input name=variantAttributeHidden' + productVariantTotalCount + '-->\n' +
                    `  <input type="hidden" value="${element.parent_attribute}"  name="variants[${productVariantTotalCount}][attributes][${index}][attribute_id]">\n` +
                    '  </td>\n' +
                    ' <td>\n' +
                    `  <select name="variants[${productVariantTotalCount}][attributes][${index}][sub_attribute]"  class="form-control" required>\n` +
                    '   <option value="">Seçiniz</option>\n' +
                    '   ' + variantItemAttributeSubAttributes + ' \n' +
                    '  </select>\n' +
                    '\n' +
                    ' </td>\n' +
                    '</div>'
            });

            let allVariantItemsHtml =
                `<div class="form-row row productVariantItem" data-index="${productVariantTotalCount}">\n` +
                '   <!-- variant id below hidden input name=variantIndexHidden{{$index}}-->\n' +
                `   <input type="hidden" value="0" name="variants[${productVariantTotalCount}][id]">\n` +
                '   <div class="form-group">\n' +
                ' ' + variantItemAttributes + ' \n' +

                // Para Birimi
                '<div class="col-md-2">\n' +
                ' <td>\n' +
                '      <label for="">Para Birimi</label>\n' +
                '      <i class="fa fa-question-circle" title="Seçilen özellikler hangi para biriminde uygulanacaksa o seçilmelidir"></i>\n' +
                '         </td>\n' +
                '  <td>\n' +
                `     <select name="variants[${productVariantTotalCount}][currency]" id="" class="form-control" required>\n` +
                '         <option value="">---Para birimi seçiniz--</option>\n' +
                `        ${currencyOptions}\n` +
                '     </select>\n' +
                '  </td>\n' +
                '</div>\n' +

                // Fiyat Bilgisi
                '<div class="col-md-1">\n' +
                '     <td><label for="">Fiyat</label></td>\n' +
                '     <td>\n' +
                `        <input type="number" class="form-control" value="" name="variants[${productVariantTotalCount}][price]" required step="any">\n` +
                '        <p class="help-block">Ürünün seçilen özelliklere ait fiyatı</p>\n' +
                '     </td>\n' +
                '</div>\n' +

                // Adet Bilgisi
                ' <div class="col-md-1">\n' +
                '   <label for="">Adet</label></td>\n' +
                `   <td><input type="number" class="form-control" value="" name="variants[${productVariantTotalCount}][qty]" required></td>\n` +
                '   <p class="help-block">Seçilen özelliklere ait adet sayısı</p>\n' +
                ' </div>\n' +


                ' <div class="form-group col-md-1">\n' +
                '   <label>&nbsp;</label><br>\n' +
                '    <a href="javascript:void(0);" onclick="deleteProductVariantItemFromForm(' + productVariantTotalCount + ')"><i\n' +
                '     class="fa fa-trash text-red"></i></a>\n' +
                '   </div>\n' +
                ' </div>\n' +
                ' </div>';
            $productVariantAttributeContainer.append(allVariantItemsHtml);
            console.log(data);
        }
    });
}

function deleteProductImage(id) {
    if (confirm('Ürüne ait fotoğraf silinecektir onaylıyor musunuz ?')) {
        $.ajax({
            url: '/admin/product/deleteProductImage/' + id + '',
            dataType: 'json',
            success: function (data) {
                if (data === true) {
                    $("#productImageCartItem" + id + "").fadeOut(600, function () {
                        this.remove();
                    });
                } else {
                    alert(data);
                }
            }
        })
    }
}

$("#parent_category_id").on('change', function () {
    getSubCategoriesByCategoryId($(this).val())
})

function getSubCategoriesByCategoryId(categoryId) {
    $.ajax({
        url: `/admin/category/getSubCategoriesByCategoryId/${categoryId}`,
        dataType: 'json',
        success: function (data) {
            var options = "";
            $("#sub_category_id option").not(':first').remove()
            $.each(data.data.categories, function (index, element) {
                options += '<option value="' + element.id + '">' + element.title + '</option>';
            });
            $("#sub_category_id").append(options)
        }
    })
}
