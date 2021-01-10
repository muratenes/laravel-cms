/**
 * kullanıcı adres düzenleme popup açar
 * @param addressID
 * @param fromRouteName hangi adresten düzenlendi odemeView,adres.odeme
 */
function editAddress(addressID, fromRouteName = 'adres.odeme') {
    $('#editAddressModal').modal('show')
    $("#addressModalTitle").text('Adres Düzenle')
    $.get(`/kullanici/address/${addressID}`, function (data) {
        $('#editAddressModal .modal-body').html(data)
        $("#fromPage").val(fromRouteName)
    })
}

/**
 * yeni adres ekleme
 * @param type adres tipi
 */
function addNewAddress(type) {
    $('#editAddressModal').modal('show')
    $("#addressModalTitle").text('Yeni Adres Ekle')
    $.get(`/kullanici/address/0`, function (data) {
        $('#editAddressModal .modal-body').html(data)
        $("#addressType").val(type)
    })
}

/**
 * il değiştiğinde şehirleri getirir.
 * @param self
 */
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
