$("#theme").on('change', function () {
    const theme = $(this).val();
    $.post(`/admin/builder/get-view-folders/${theme}`)
        .then(response => {
            console.log(response);
            fillSelect("#banner", response.data.banners)
            fillSelect("#header", response.data.headers)
            fillSelect("#footer", response.data.footers)
            fillSelect("#contact", response.data.contacts)
        }).catch(error => {
        fillSelect("#banner", {});
        fillSelect("#header", {});
        fillSelect("#footer", {});
        fillSelect("#contact", {});
    });
});

function fillSelect(selector, items) {
    $(items).each(function () {
        $(selector).children().remove();
        var options = "";
        $.each(items, function (index, element) {
            options += '<option value="' + element + '">' + element + '</option>';
        });
        $(selector).append(options);
    })
}
