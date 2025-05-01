$(document).ready(function () {
    // Yeni satır ekle
    $('#add-row').on('click', function () {
        const newRow = $('.esnaf-template').html();
        const $newRow = $(newRow);
        $('#esnaf-rows').append($newRow);

    });

    // Satır sil
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });
});
