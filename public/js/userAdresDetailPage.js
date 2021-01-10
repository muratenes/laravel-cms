$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function deleteAddress(addressID) {
    $(`#address-delete-form-${addressID}`).submit()
}

function citySelectOnChange(self) {
    $.ajax({
        url: '/locations/getTownsByCityId/' + self.value + '',
        success: function (data) {
            bindTownSelectAndDistrictClear(data);
        }
    })
}

function bindTownSelectAndDistrictClear(cities) {
    $("#district option").not(':eq(0)').remove();
    $(cities).each(function (index, element) {
        $("#district").append('<option value="' + element.id + '">' + element.title + '</option>')
    })
}

function townSelectOnChange(self) {
    $("#district option").not(':eq(0)').remove();
    $.ajax({
        url: '/cityTownService/getDistrictsByTownId/' + self.value + '',
        success: function (data) {
            $(data).each(function (index, element) {
                $("#district").append('<option value="' + element.id + '">' + element.title + '</option>')
            })
        }
    })
}

function saveAdresDetail($redirectUrl) {
    var form = document.getElementById('adresDetailForm');
    var adresId = $("#addressId").val();
    if (form.checkValidity()) {
        $.post('/kullanici/adres/', {
            data: {
                adresId: adresId,
                title: $("#title").val(),
                name: $("#name").val(),
                surname: $("#surname").val(),
                city: $("#city").val(),
                town: $("#town").val(),
                type: $("#type").val(),
                adres: $("#adres").val(),
                phone: $("#phone").val(),
            }
        }, function (data, status) {
            if (Object.keys(data.errors).length > 0) {
                $(".alert-danger").show();
                var message = "";
                var errors = data.errors;
                Object.keys(errors).forEach(function (key) {
                    message += errors[key] + "\n";
                })
                $("#alertMessage").text(message);
            } else {
                $(".alert-danger").hide();
                window.location.href = $redirectUrl
            }
        })
    }
}

function invoiceFormAddOrRemoveRequired() {
    var isChecked = $("#change-bill-address").prop('checked');
    if (isChecked) {
        $("#title,#name,#surname,#phone,#city,#town,#adres").attr("required", "required");
    } else {
        $("#title,#name,#surname,#phone,#city,#town,#adres").removeAttr("required");
    }

}
