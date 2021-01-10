
function deleteProductProperties(index) {
    $("#productPropertyContainer" + index).remove();
}

function deleteProductPropertiesByLanguage(index, language) {
    console.log($(`#product-property-container-${language}-${index}`))
    $(`#product-property-container-${language}-${index}`).remove();
}


function bindAllSubCats(kendi, appendToElementId) {
    $.ajax({
        url: '/home/getAllAltKategori',
        dataType: 'json',
        data: {
            'id': kendi
        },
        success: function (data) {
            $("#subCat option").not(":first").remove()
            $(JSON.parse(data.models)).each(function (index, element) {
                $('<option />', {
                    'value': element.pk,
                    'text': element.fields.title,
                }).appendTo($("#" + appendToElementId + ""));
            });
        }, error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    })
}

function removeImageById(kendi) {
    $.ajax({
        url: '/magaza/admin/urun/removeImage/',
        dataType: 'json',
        data: {
            'itemId': kendi,
            'className': "Files",
        },
        success: function (data) {
            var sonuc = JSON.parse(data.models)
            console.log(sonuc)
            if (sonuc == true) {
                $("#divProductGalleryItem" + kendi + "").hide(1000)
            } else {
                alert("resim silinirken bir hata oluÅŸtu")
            }

        }
    })
}

function deleteProduct(kendi) {
    var txt;
    var r = confirm("ÃœrÃ¼n Silme Ä°ÅŸlemi ! \n \n eÄŸer bu Ã¼rÃ¼nÃ¼ silerseniz Ã¼rÃ¼nle ilgili bÃ¼tÃ¼n nesneleri silmiÅŸ olacaksÄ±nÄ±z \n Silmek istediÄŸine emin misin ?");
    if (r == true) {
        $.ajax({
            url: '/magaza/admin/urun/urun-sil/',
            dataType: 'json',
            data: {
                'productId': kendi,
            },
            success: function (data) {
                var sonuc = JSON.parse(data.models)
                console.log(sonuc)
                if (sonuc == true) {
                    $("#product-item-" + kendi + "").hide(1000)
                } else {
                    alert("resim silinirken bir hata oluÅŸtu")
                }

            }
        })
    } else {
        txt = "You pressed Cancel!";
    }

}
