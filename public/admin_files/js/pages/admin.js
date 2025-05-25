$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function createdAt(date) {
    return moment(date).format('DD/MM/Y H:mm:ss');
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('/admin/init', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
    })
        .then(response => response.json())
        .then(data => {
            window.appSettings = data;
        })
        .catch(error => {
            errorMessage("Genel ayarlar yüklenemedi")
        });
});

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(document).ready(function () {
    $("#vendor_id_filter").select2({width:'100%'})
    $("[id*='count']").each(function (index, element) {
        if ($(element).val() !== "0") {
            $("#" + $(element).data('item')).append(`<small class="label pull-right bg-red" >${$(element).val()}</small>`)
        }
    })
})

/**
 * show validation errors or any errors
 * @param response
 */
function errorMessage(response) {
    if (response.status === 400) {
        const data = JSON.parse(response.responseText);
        toastr.error(data.message)
    }
}

function showErrorMessage(message) {
    toastr.error(message)
}

/**
 * show success alert message
 * @param message
 */
function successMessage(message) {
    toastr.success(message)
}

/**
 *  get url param value
 * @param sParam
 * @returns {boolean|string}
 */
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


