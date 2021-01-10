$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function addNewProductAttributeItem() {
    let $productAttributeCount =
        isNaN($(".productSubAttribute").last().attr("data-index")) ? 0 :
        parseInt($(".productSubAttribute").last().attr("data-index")) + 1;
    console.log('ar');
    $.post({
        url: "/admin/product/attributes/get-new-product-sub-attribute-html/", data: {
            index: $productAttributeCount
        }
    }, function (response) {
        $("#productSubAttributeContainer").append(response);
    });
}


function deleteProductSubAttributeFromDB($id, $index) {
    if (confirm('bu alt özellik silinecektir onayluyor musunuz ?')) {
        $.post({
            url: "/admin/product/attributes/deleteSubAttribute/" + $id + "",
            dataType: 'json',
            success: function (data) {
                if (data === "true") {
                    deleteProductSubAttributeFromForm($index);
                } else {
                    alert(data);
                }
            }
        })
    }
}

function deleteProductSubAttributeFromForm($index) {
    $("#productSubAttributeContainer > div.col-md-12").eq($index).fadeOut(300, function () {
        this.remove();
    });
}
