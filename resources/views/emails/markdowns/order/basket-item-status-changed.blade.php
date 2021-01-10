@component('mail::message')
    # Sipariş Bilgileri

    ## Ürün Bilgileri

    ### Tech

    > The overriding design goal for Markdown's
    > formatting syntax is to make it as readable
    > as possible. The idea is that a
    > Markdown-formatted document should be
    > publishable as-is, as plain text, without
    > looking like it's been marked up with tags
    > or formatting instructions.



    @component('mail::button', ['url' => $productUrl])
        Sipariş Detay Görüntüler
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
