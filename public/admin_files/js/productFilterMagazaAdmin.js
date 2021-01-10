// list marka


function chcMarkaOnChange(index) {
    index -= 1;
    bindAllModels(index);
}


// list marka => bind all Models Ajax Code Function
function bindAllModels(index) {
    $.ajax({
        url: '/brands/getModelsByBrand',
        dataType: 'json',
        data: {
            'brand_slug': $(".chc_marka:eq(" + index + ")").val(),
        },
        success: function (data) {
            clearSelect($(".chc_model:eq(" + index + ")"))
            clearSelect($(".chc_kasa:eq(" + index + ")"))
            clearSelect($(".chc_yil:eq(" + index + ")"))
            clearSelect($(".chc_motor_hacmi:eq(" + index + ")"))
            clearSelect($(".chc_beygir_gucu:eq(" + index + ")"))

            bindSelectOptionByName(JSON.parse(data.models), "chc_model", index);
            console.log(JSON.parse(data.models))


        }
    })
}

// bind kasa by model
function chcModelOnChange(index) {
    index -= 1;
    bindAllKasaWithAjax(index);
}

// bind kasa by model => bind all Kasa Ajax Code Function
function bindAllKasaWithAjax(index) {
    $.ajax({
        url: '/brands/getKasasByModel',
        dataType: 'json',
        data: {
            'brand_slug': $(".chc_marka:eq(" + index + ")").val(),
            'model_slug': $(".chc_model:eq(" + index + ")").val(),
        },
        success: function (data) {
            clearSelect($(".chc_kasa:eq(" + index + ")"))
            clearSelect($(".chc_yil:eq(" + index + ")"))
            clearSelect($(".chc_motor_hacmi:eq(" + index + ")"))
            clearSelect($(".chc_beygir_gucu:eq(" + index + ")"))

            bindSelectOptionByName(JSON.parse(data.models), "chc_kasa", index);


        }
    })
}

// bind yil by kasa
function chcKasaOnChange(index) {
    index -= 1;
    $.ajax({
        url: '/brands/getYilByKasa',
        dataType: 'json',
        data: {
            'brand_slug': $(".chc_marka:eq(" + index + ")").val(),
            'model_slug': $(".chc_model:eq(" + index + ")").val(),
            'kasa_slug': $(".chc_kasa:eq(" + index + ")").val(),
        },
        success: function (data) {
            bindSelectOptionByName(JSON.parse(data.models), "chc_yil", index);

        }
    })
}

//bind Motor Hacmi by Yil
function chcModelYiliOnChange(index) {
    index -= 1;
    $.ajax({
        url: '/brands/getMotorHacmiByYil',
        dataType: 'json',
        data: {
            'brand_slug': $(".chc_marka:eq(" + index + ")").val(),
            'model_slug': $(".chc_model:eq(" + index + ")").val(),
            'kasa_slug': $(".chc_kasa:eq(" + index + ")").val(),
            'yil_slug': $(".chc_yil:eq(" + index + ")").val(),
        },
        success: function (data) {
            bindSelectOptionByName(JSON.parse(data.models), "chc_motor_hacmi", index);


        }
    })

};

//bind Beygir Gücü by Motor Hacmi
function chcMotorHacmiOnChange(paramIndex) {
    paramIndex -= 1;
    $.ajax({
        url: '/brands/getBeygirGucuByMotorHacmi',
        dataType: 'json',
        data: {
            'brand_slug': $(".chc_marka:eq(" + paramIndex + ")").val(),
            'model_slug': $(".chc_model:eq(" + paramIndex + ")").val(),
            'kasa_slug': $(".chc_kasa:eq(" + paramIndex + ")").val(),
            'yil_slug': $(".chc_yil:eq(" + paramIndex + ")").val(),
            'motor_hacmi_slug': $(".chc_motor_hacmi:eq(" + paramIndex + ")").val(),
        },
        success: function (data) {
            clearSelect($(".chc_beygir_gucu:eq(" + paramIndex + ")"));
            $(JSON.parse(data.sayisalBeyGirler)).each(function (index, element) {
                $(".chc_beygir_gucu:eq(" + paramIndex + ")").append(new Option(element.fields.beygir_gucu, element.fields.slug));
            });


        }
    })

};

// ortak fonksiyonlar
function bindSelectOptionByName(ModelObjects, selectBoxClassName, Index) {
    clearSelect($("." + selectBoxClassName + ":eq(" + Index + ")"));
    $(ModelObjects).each(function (index, element) {
        var dger = false;
        if (element.fields.slug == "doblo")
            dger = true
        $('<option />', {
            'value': element.fields.slug,
            'text': element.fields.title,
            'class': element.fields.slug,
            // 'selected': (dger)
        }).appendTo($("." + selectBoxClassName + ":eq(" + Index + ")"));
        // $("#" + selectBoxID + "").append(new Option(element.fields.title, element.fields.slug));
    });
}

// clear options on select by parameter
function clearSelect(selectElement) {
    //selectElement.find('option').remove();
    $(selectElement.find("option")).each(function (index, element) {
        if (element.value != "0")
            element.remove()
    });
    // selectElement.append(new Option("---" + selectElement.attr("data-text") + " Seçiniz ---", 0))
}