$(function () {
    let defaultStart = moment().startOf('month');
    let defaultEnd = moment();

    let urlRange = getDateRangeFromUrl();
    let start = urlRange ? urlRange[0] : defaultStart;
    let end = urlRange ? urlRange[1] : defaultEnd;

    function updateInput(start, end) {
        $('#dateRangePicker').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    }


    $('#dateRangePicker').daterangepicker({
        startDate: start,
        endDate: end,
        autoUpdateInput: true,
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'Uygula',
            cancelLabel: 'İptal',
            fromLabel: 'Başlangıç',
            toLabel: 'Bitiş',
            customRangeLabel: 'Özel Aralık',
            daysOfWeek: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct'],
            monthNames: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran',
                'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            firstDay: 1
        },
        ranges: {
            'Bu Hafta': [moment().startOf('week').add(1, 'days'), moment()],
            'Bu Ay': [moment().startOf('month'), moment()],
            'Son 1 Hafta': [moment().subtract(6, 'days'), moment()],
            'Son 1 Ay': [moment().subtract(1, 'months').startOf('day'), moment()],
            'Geçen Ay': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Bu Sene': [moment().startOf('year'), moment()]
        }
    }, updateInput);

});

function getDateRangeFromUrl() {
    const params = new URLSearchParams(window.location.search);
    const dateRange = params.get('date_range');
    if (dateRange) {
        const [start, end] = dateRange.split(' - ');
        if (moment(start, 'YYYY-MM-DD', true).isValid() && moment(end, 'YYYY-MM-DD', true).isValid()) {
            return [moment(start), moment(end)];
        }
    }
    return null;
}
