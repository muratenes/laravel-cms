<h1> {{ config('app.name') }}</h1>

<p> Merhaba {{ $kullanici ->full_name }} Kaydınız başarılı bir şekilde yapıldı</p>

<p>Kaydınızı aktif hale getirmek için <a href="{{ config('app.url') }}/kullanici/aktiflestir/{{ $kullanici->activation_code }}">tıklayınız</a> veya aşğıdaki bağlantıyı açınız</p>

<p>{{ config('app.url') }}/kullanici/aktiflestir/{{ $kullanici->activation_code }} </p>
