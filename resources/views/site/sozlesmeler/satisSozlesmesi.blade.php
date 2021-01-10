{{--MESAFELİ SATIŞ SÖZLEŞMESİ <br>--}}
{{--<br>--}}
{{--MADDE 1- TARAFLAR <br>--}}
{{--<br>--}}
{{--1.1- SATICI: <br>--}}

{{--Ünvanı : {{ $site->full_name }} <br>--}}
{{--Adresi : {{ $site->company_address }} <br>--}}
{{--Telefon :{{ $site->phone }} <br>--}}
{{--Fax : {{ $site->fax }} <br>--}}
{{--E-mail:{{ $site->email }} <br>--}}
{{--<br>--}}
{{--1.2- ALICI: <br>--}}
{{--<br>--}}
{{--Adı/Soyadı/Ünvanı : {{ $address->name . ' '. $address->surname }} <br>--}}
{{--Adresi: {{ $address->adres . ' '. $address->Town->title . '/'. $address->City->title }} <br>--}}
{{--Telefon:{{ $address->phone }} <br>--}}
{{--E-mail:{{ $address->User->email }} <br>--}}
{{--Tc No: <br>--}}
{{--<br>--}}
{{--MADDE 2- KONU <br>--}}
{{--<br>--}}
{{--İşbu sözleşmenin konusu, ALICI'nın SATICI'ya ait {{ $site->domain }} internet sitesinden elektronik ortamda siparişini yaptığı aşağıda nitelikleri ve satış fiyatı belirtilen ürünün satışı ve teslimi ile ilgili olarak 4077 sayılı Tüketicilerin Korunması Hakkındaki Kanun ve Mesafeli Sözleşmeleri Uygulama Esas ve Usulleri Hakkında Yönetmelik hükümleri gereğince tarafların hak ve yükümlülüklerinin saptanmasıdır.--}}
{{--<br>--}}
{{--<br>--}}
{{--MADDE 3- SÖZLEŞME KONUSU ÜRÜN <br>--}}
{{--<br>--}}
{{--Tarih :09.12.19 <br>--}}
{{--<br>--}}
{{--<table class="table">--}}
{{--    <tr>--}}
{{--        <th>Ürün adı</th>--}}
{{--        <th>Adet</th>--}}
{{--        <th>Fiyat</th>--}}
{{--        <th>Toplam Tutar</th>--}}
{{--    </tr>--}}
{{--    @foreach(Cart::getContent() as $item)--}}

{{--        <tr>--}}
{{--            <td>{{$item->name}}</td>--}}
{{--            <td>{{$item->qty}}</td>--}}
{{--            <td>₺ {{$item->price}}</td>--}}
{{--            <td>₺ {{$item->price * $item->quantity}} </td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--</table>--}}
{{--<table class="table table-totals">--}}
{{--    <tbody>--}}
{{--    <tr>--}}
{{--        <td>Ara Toplam</td>--}}
{{--        <td>₺<span class="cartTotal">{{ $prices['cartSubTotalPrice'] }}</span></td>--}}
{{--    </tr>--}}
{{--    <tr>--}}
{{--        <td>Kargo</td>--}}
{{--        <td>₺<span>{{ $prices['cargoPrice'] }}</span></td>--}}
{{--    </tr>--}}
{{--    @if(!is_null($prices['basketCoupon']))--}}
{{--        <tr>--}}
{{--            <td>Kupon - {{$prices['basketCoupon']->code}}</td>--}}
{{--            <td style="color: green">- ₺<span class="text-green bg-green">{{$prices['basketCoupon']->discount_price}}</span></td>--}}
{{--        </tr>--}}
{{--    @endif--}}
{{--    </tbody>--}}
{{--    <tfoot>--}}
{{--    <tr>--}}
{{--        <td>Genel Toplam</td>--}}
{{--        <td>₺<span class="cartTotal text-bold">{{ $prices['cartTotalPrice']  }}</span></td>--}}
{{--    </tr>--}}
{{--    </tfoot>--}}


{{--</table>--}}
{{--Ürünlerin cinsi ve türü,miktarı,marka/modeli rengi satış bedeli yukarıda belirtildiği gibidir. <br>--}}

{{--Ödeme şekli: Kredi Kartı <br>--}}
{{--Teslimat adresi: {{$address->title}} - {{$address->adres}} -{{$address->Town->title}} - {{$address->City->title}} - +90{{$address->phone}}--}}
{{--@if($defaultInvoiceAddress)--}}
{{--    Fatura adresi: {{$defaultInvoiceAddress->title}} - {{$defaultInvoiceAddress->adres}} -{{$defaultInvoiceAddress->Town->title}} - {{$defaultInvoiceAddress->City->title}} - +90{{$defaultInvoiceAddress->phone}}--}}
{{--    <br>--}}
{{--@else--}}
{{--    Fatura adresi: {{$address->title}} - {{$address->adres}} -{{$address->Town->title}} - {{$address->City->title}} - +90{{$address->phone}} <br>--}}
{{--@endif--}}
{{--<br>--}}
{{--Ödenmiş toplam tutar :{{ $prices['cartTotalPrice']  }} ₺ <br>--}}

{{--MADDE 4- GENEL HÜKÜMLER <br>--}}

{{--4.1- ALICI, {{ $site->domain }} internet sitesinde sözleşme konusu ürünün temel nitelikleri, satış fiyatı ve ödeme şekli ile teslimata ilişkin ön bilgileri okuyup bilgi sahibi olduğunu ve elektronik ortamda gerekli teyidi verdiğini beyan eder.--}}
{{--<br>--}}
{{--4.2- Sözleşme konusu ürün, yasal 30 günlük süreyi aşmamak koşulu ile her bir ürün için ALICI'nın yerleşim yerinin uzaklığına bağlı olarak internet sitesinde ön bilgiler içinde açıklanan süre içinde ALICI veya gösterdiği adresteki kişi/kuruluşa teslim edilir.--}}
{{--<br>--}}
{{--4.3- Sözleşme konusu ürün, ALICI'dan başka bir kişi/kuruluşa teslim edilecek ise, teslim edilecek kişi/kuruluşun teslimatı kabul etmemesininden SATICI sorumlu tutulamaz. <br>--}}
{{--4.4- SATICI, sözleşme konusu ürünün sağlam, eksiksiz, siparişte belirtilen niteliklere uygun ve varsa garanti belgeleri ve kullanım klavuzları ile teslim edilmesinden sorumludur. <br>--}}
{{--4.5- Sözleşme konusu ürünün teslimatı için işbu sözleşmenin imzalı nüshasının SATICI'ya ulaştırılmış olması ve bedelinin ALICI'nın tercih ettiği ödeme şekli ile ödenmiş olması şarttır. Herhangi bir nedenle ürün bedeli ödenmez veya banka kayıtlarında iptal edilir ise, SATICI ürünün teslimi yükümlülüğünden kurtulmuş kabul edilir.--}}
{{--<br>--}}
{{--4.6- Ürünün tesliminden sonra ALICI'ya ait kredi kartının ALICI'nın kusurundan kaynaklanmayan bir şekilde yetkisiz kişilerce haksız veya hukuka aykırı olarak kullanılması nedeni ile ilgili banka veya finans kuruluşun ürün bedelini SATICI'ya ödememesi halinde, ALICI'nın kendisine teslim edilmiş olması kaydıyla ürünün 3 gün içinde SATICI'ya gönderilmesi zorunludur. Bu takdirde nakliye giderleri ALICI'ya aittir.--}}
{{--<br>--}}
{{--4.7- SATICI mücbir sebepler veya nakliyeyi engelleyen hava muhalefeti, ulaşımın kesilmesi gibi olağanüstü durumlar nedeni ile sözleşme konusu ürünü süresi içinde teslim edemez ise, durumu ALICI'ya bildirmekle yükümlüdür. Bu takdirde ALICI siparişin iptal edilmesini, sözleşme konusu ürünün varsa emsali ile değiştirilmesini, ve/veya teslimat süresinin engelleyici durumun ortadan kalkmasına kadar ertelenmesi haklarından birini kullanabilir. ALICI'nın siparişi iptal etmesi halinde ödediği tutar 10 gün içinde kendisine nakten ve defaten ödenir.--}}
{{--<br>--}}
{{--4.8- Garanti belgesi ile satılan ürünlerden olan veya olmayan ürünlerin arızalı veya bozuk olanlar, garanti şartları içinde gerekli onarımın yapılması için SATICI'ya gönderilebilir, bu takdirde kargo giderleri SATICI tarafından karşılanacaktır.--}}
{{--<br>--}}
{{--4.9- Kargo Teslimat süresi 2 ile 5 iş günü içerisinde değişiklik gösterebilir. <br>--}}
{{--<br>--}}
{{--<br>--}}
{{--MADDE 5- CAYMA HAKKI <br>--}}
{{--<br>--}}
{{--ALICI, sözleşme konusu ürürünün kendisine veya gösterdiği adresteki kişi/kuruluşa tesliminden itibaren 7 gün içinde cayma hakkına sahiptir. Cayma hakkının kullanılması için bu süre içinde SATICI'ya faks, email veya telefon ile bildirimde bulunulması ve ürünün 6. madde hükümleri çercevesinde kullanılmamış olması şarttır. Bu hakkın kullanılması halinde, 3. kişiye veya ALICI'ya teslim edilen ürünün SATICI'ya gönderildiğine ilişkin kargo teslim tutanağı örneği ile fatura aslının iadesi zorunludur. Bu belgelerin ulaşmasını takip eden 7 gün içinde ürün bedeli ALICI'ya iade edilir. Fatura aslı gönderilmez ise KDV ve varsa sair yasal yükümlülükler iade edilemez. Cayma hakkı nedeni ile iade edilen ürünün kargo bedeli SATICI tarafından karşılanır.--}}
{{--<br>--}}
{{--<br>--}}
{{--MADDE 6- CAYMA HAKKI KULLANILAMAYACAK ÜRÜNLER <br>--}}
{{--<br>--}}
{{--Niteliği itibarıyla iade edilemeyecek ürünler, tek kullanımlık ürünler, kopyalanabilir yazılım ve programlar, hızlı bozulan veya son kullanım tarihi geçen ürünler için cayma hakkı kullanılamaz. Aşağıdaki ürünlerde cayma hakkının kullanılması, ürünün ambalajının açılmamış, bozulmamış ve ürünün kullanılmamış olması şartına bağlıdır.--}}
{{--<br>--}}
{{--<br>--}}
{{---Taşınabilir Bilgisayar (Orijinal işletim sitemi kurulduktan sonra iade alınmayacaktır.) <br>--}}
{{---Her türlü yazılım ve programlar <br>--}}
{{---DVD, VCD, CD ve kasetler <br>--}}
{{---Bilgisayar ve kırtasiye sarf malzemeleri (toner, kartuş, şerit v.b) <br>--}}
{{---Hür türlü kozmetik ürünleri <br>--}}
{{---Telefon kontör siparişleri <br>--}}
{{--<br>--}}
{{--MADDE 7- YETKİLİ MAHKEME <br>--}}
{{--<br>--}}
{{--İşbu sözleşmenin uygulanmasında, Sanayi ve Ticaret Bakanlığınca ilan edilen değere kadar Tüketici Hakem Heyetleri ile ALICI'nın veya SATICI'nın yerleşim yerindeki Tüketici Mahkemeleri yetkilidir.--}}
{{--<br>--}}
{{--<br>--}}
{{--Siparişin gerçekleşmesi durumunda ALICI işbu sözleşmenin tüm koşullarını kabul etmiş sayılır. <br>--}}
{{--<br>--}}
{{--SATICI <br>--}}
{{--<br>--}}
{{--{{ $site->title }} <br>--}}
{{--<br>--}}
{{--ALICI--}}
{{--<br>--}}
{{--{{$address->name . ' '. $address->surname}} <br>--}}
{{--<br>--}}
