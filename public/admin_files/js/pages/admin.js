$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function createdAt(date) {
    return moment(date).format('DD/MM/Y H:mm:ss');
}

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
    const pendingOrderCount = $("#pendingOrderCount").val()
    const pendingRefundRequests = $("#pendingRefundRequests").val()
    if (pendingOrderCount) {
        $("#label_pendingOrderCount").append(`<span class="pull-right-container"><small class="label pull-right bg-green" title="Bekleyen siparişler">${pendingOrderCount}</small></span>`);
    }
    if (pendingRefundRequests) {
        $("#label_pendingRefundRequests").append(`<span class="pull-right-container"><small class="label pull-right bg-red" title="İade talebi oluşturulanlar">${pendingRefundRequests}</small></span>`);
    }

})

