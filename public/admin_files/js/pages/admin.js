$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function createdAt(date) {
    return moment(date).format('DD/MM/Y H:mm:ss');
}

