@if(session()->has('threeDSHtmlContent'))
    {!! base64_decode(session()->get('threeDSHtmlContent'))  !!}
@else
    <p>3d güvenli ödeme sırasında bir sorun oluştu. içerik alınamadı</p>
@endif
