{{--ÖN BİLGİLENDİRME FORMU <br>--}}
{{--<br>--}}
{{--1.KONU--}}
{{--<br>--}}
{{--İşbu Satış Sözleşmesi Ön Bilgi Formu’nun konusu, SATICI' nın, SİPARİŞ VEREN/ALICI' ya satışını yaptığı, aşağıda nitelikleri ve satış fiyatı belirtilen ürün/ürünlerin satışı ve teslimi ile ilgili olarak 6502 sayılı Tüketicilerin Korunması Hakkındaki Kanun - Mesafeli Sözleşmeler Yönetmeliği (RG:27.11.2014/29188) hükümleri gereğince tarafların hak ve yükümlülüklerini kapsamaktadır. İş bu ön bilgilendirme formunu kabul etmekle ALICI, sözleşme konusu siparişi onayladığı takdirde sipariş konusu bedeli ve varsa kargo ücreti, vergi gibi belirtilen ek ücretleri ödeme yükümlülüğü altına gireceğini ve bu konuda bilgilendirildiğini peşinen kabul eder.--}}
{{--<br>--}}
{{--2. SATICI BİLGİLERİ <br>--}}
{{--Ünvanı : {{ $owner->full_name }} <br>--}}
{{--Adresi : {{ $owner->company_address }} <br>--}}
{{--Telefon :{{ $owner->phone }} <br>--}}
{{--Fax : {{ $owner->fax }} <br>--}}
{{--E-mail:{{ $owner->email }} <br>--}}
{{--<br>--}}

{{--3. ALICI Bilgileri: <br>--}}
{{--<br>--}}
{{--Adı/Soyadı/Ünvanı : {{ $address->name . ' '. $address->surname }} <br>--}}
{{--Adresi: {{ $address->adres . ' '. $address->Town->title . '/'. $address->City->title }} <br>--}}
{{--Telefon:{{ $address->phone }} <br>--}}
{{--E-mail:{{ $address->User->email }} <br>--}}
{{--Tc No: <br>--}}
{{--<br>--}}
{{--<br>--}}
{{--4. SÖZLEŞME KONUSU ÜRÜN/ÜRÜNLER BİLGİLERİ <br>--}}
{{--<br>--}}
{{--4.1 Malın / Ürün/Ürünlerin / Hizmetin temel özellikleri (türü, miktarı, marka/modeli, rengi, adedi) SATICI’ya ait internet sitesinde yer almaktadır. Ürünün temel özelliklerini kampanya süresince inceleyebilirsiniz. Kampanya tarihine kadar geçerlidir.--}}
{{--<br> <br>--}}
{{--4.2 Listelenen ve sitede ilan edilen fiyatlar satış fiyatıdır. İlan edilen fiyatlar ve vaatler güncelleme yapılana ve değiştirilene kadar geçerlidir. Süreli olarak ilan edilen fiyatlar ise belirtilen süre sonuna kadar geçerlidir.--}}
{{--<br> <br>--}}
{{--4.3 Sözleşme konusu mal ya da hizmetin tüm vergiler dâhil satış fiyatı aşağıdaki tabloda gösterilmiştir.<br> <br>--}}
{{--<br>--}}
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
{{--<br>--}}
{{--Teslimat adresi: {{$address->title}} - {{$address->adres}} -{{$address->Town->title}} - {{$address->City->title}} - +90{{$address->phone}} <br>--}}
{{--@if($defaultInvoiceAddress)--}}
{{--    Fatura adresi: {{$defaultInvoiceAddress->title}} - {{$defaultInvoiceAddress->adres}} -{{$defaultInvoiceAddress->Town->title}} - {{$defaultInvoiceAddress->City->title}} - +90{{$defaultInvoiceAddress->phone}}--}}
{{--    <br>--}}
{{--    <br>--}}
{{--@else--}}
{{--    Fatura adresi: {{$address->title}} - {{$address->adres}} -{{$address->Town->title}} - {{$address->City->title}} - +90{{$address->phone}} <br>--}}
{{--@endif--}}
{{--Sipariş Tarihi : {{ date('dd/mm/yyyy') }}<br>--}}

{{--5. GENEL HÜKÜMLER<br>--}}
{{--<br>--}}
{{--5.1. ALICI, SATICI’ya ait internet sitesinde sözleşme konusu ürünün temel nitelikleri, satış fiyatı ve ödeme şekli ile teslimata ilişkin ön bilgileri okuyup, bilgi sahibi olduğunu, elektronik ortamda gerekli teyidi verdiğini kabul, beyan ve taahhüt eder. ALICININ; Ön Bilgilendirmeyi elektronik ortamda teyit etmesi, mesafeli satış sözleşmesinin kurulmasından evvel, SATICI tarafından ALICI' ya verilmesi gereken adresi, siparişi verilen ürünlere ait temel özellikleri, ürünlerin vergiler dâhil fiyatını, ödeme ve teslimat bilgilerini de doğru ve eksiksiz olarak edindiğini kabul, beyan ve taahhüt eder.--}}
{{--<br>--}}

{{--5.2. Sözleşme konusu her bir ürün, 30 günlük yasal süreyi aşmamak kaydı ile ALICI' nın yerleşim yeri uzaklığına bağlı olarak internet sitesindeki ön bilgiler kısmında belirtilen süre zarfında ALICI veya ALICI’ nın gösterdiği adresteki kişi ve/veya kuruluşa teslim edilir. Bu süre içinde ürünün ALICI’ya teslim edilememesi durumunda, ALICI’nın sözleşmeyi feshetme hakkı saklıdır.--}}
{{--<br>--}}

{{--5.3. SATICI, sözleşme konusu ürünü eksiksiz, siparişte belirtilen niteliklere uygun ve varsa garanti belgeleri, kullanım kılavuzları ile teslim etmeyi, her türlü ayıptan arî olarak yasal mevzuat gereklerine sağlam, standartlara uygun bir şekilde işin gereği olan bilgi ve belgeler ile işi doğruluk ve dürüstlük esasları dâhilinde ifa etmeyi, hizmet kalitesini koruyup yükseltmeyi, işin ifası sırasında gerekli dikkat ve özeni göstermeyi, ihtiyat ve öngörü ile hareket etmeyi kabul, beyan ve taahhüt eder.--}}
{{--<br>--}}

{{--5.4. SATICI, sözleşmeden doğan ifa yükümlülüğünün süresi dolmadan ALICI’yı bilgilendirmek ve açıkça onayını almak suretiyle eşit kalite ve fiyatta farklı bir ürün tedarik edebilir. <br>--}}

{{--5.5. SATICI, sipariş konusu ürün veya hizmetin yerine getirilmesinin imkânsızlaşması halinde sözleşme konusu yükümlülüklerini yerine getiremezse, bu durumu, öğrendiği tarihten itibaren 3 gün içinde yazılı olarak tüketiciye bildireceğini, 14 günlük süre içinde toplam bedeli ALICI’ya iade edeceğini kabul, beyan ve taahhüt eder.--}}
{{--<br>--}}

{{--5.6. ALICI, sözleşme konusu ürünün teslimatı için işbu Ön Bilgilendirme Formunu elektronik ortamda teyit edeceğini, herhangi bir nedenle sözleşme konusu ürün bedelinin ödenmemesi ve/veya banka kayıtlarında iptal edilmesi halinde, SATICI’ nın sözleşme konusu ürünü teslim yükümlülüğünün sona ereceğini kabul, beyan ve taahhüt eder.--}}
{{--<br>--}}

{{--5.7. ALICI, Sözleşme konusu ürünün ALICI veya ALICI’nın gösterdiği adresteki kişi ve/veya kuruluşa tesliminden sonra ALICI'ya ait kredi kartının yetkisiz kişilerce haksız kullanılması sonucunda sözleşme konusu ürün bedelinin ilgili banka veya finans kuruluşu tarafından SATICI'ya ödenmemesi halinde, ALICI Sözleşme konusu ürünü 3 gün içerisinde nakliye gideri SATICI’ya ait olacak şekilde SATICI’ya iade edeceğini kabul, beyan ve taahhüt eder.--}}
{{--<br>--}}

{{--5.8. SATICI, tarafların iradesi dışında gelişen, önceden öngörülemeyen ve tarafların borçlarını yerine getirmesini engelleyici ve/veya geciktirici hallerin oluşması gibi mücbir sebepler halleri nedeni ile sözleşme konusu ürünü süresi içinde teslim edemez ise, durumu ALICI' ya bildireceğini kabul, beyan ve taahhüt eder. ALICI da siparişin iptal edilmesini, sözleşme konusu ürünün varsa emsali ile değiştirilmesini ve/veya teslimat süresinin engelleyici durumun ortadan kalkmasına kadar ertelenmesini SATICI’ dan talep etme hakkına haizdir. ALICI tarafından siparişin iptal edilmesi halinde ALICI’ nın nakit ile yaptığı ödemelerde, ürün tutarı 14 gün içinde kendisine nakden ve defaten ödenir. ALICI’ nın kredi kartı ile yaptığı ödemelerde ise, ürün tutarı, siparişin ALICI tarafından iptal edilmesinden sonra 14 gün içerisinde ilgili bankaya iade edilir. ALICI, SATICI tarafından kredi kartına iade edilen tutarın banka tarafından ALICI hesabına yansıtılmasına ilişkin ortalama sürecin 2 ile 3 haftayı bulabileceğini, bu tutarın bankaya iadesinden sonra ALICI’ nın hesaplarına yansıması halinin tamamen banka işlem süreci ile ilgili olduğundan, ALICI, olası gecikmeler için SATICI’ yı sorumlu tutamayacağını kabul, beyan ve taahhüt eder.--}}
{{--<br>--}}

{{--5.9.Kargo teslim süresi 2 ila 5 iş günü içerisinde değişiklik gösterebilmektedir. <br>--}}

{{--6. FATURA BİLGİLERİ--}}
{{--@if($defaultInvoiceAddress)--}}
{{--    {{$defaultInvoiceAddress->title}} - {{$defaultInvoiceAddress->adres}} -{{$defaultInvoiceAddress->Town->title}} - {{$defaultInvoiceAddress->City->title}} - +90{{$defaultInvoiceAddress->phone}}--}}
{{--    <br>--}}
{{--@else--}}
{{--    {{$address->title}} - {{$address->adres}} -{{$address->Town->title}} - {{$address->City->title}} - +90{{$address->phone}} <br>--}}
{{--@endif--}}

{{--7. CAYMA HAKKI <br>--}}
{{--7.1. ALICI; mal satışına ilişkin mesafeli sözleşmelerde, ürünün kendisine veya gösterdiği adresteki kişi/kuruluşa teslim tarihinden itibaren 14 (on dört) gün içerisinde, SATICI’ya bildirmek şartıyla hiçbir hukuki ve cezai sorumluluk üstlenmeksizin ve hiçbir gerekçe göstermeksizin malı reddederek sözleşmeden cayma hakkını kullanabilir. Hizmet sunumuna ilişkin mesafeli sözleşmelerde ise, bu süre sözleşmenin imzalandığı tarihten itibaren başlar. Cayma hakkı süresi sona ermeden önce, tüketicinin onayı ile hizmetin ifasına başlanan hizmet sözleşmelerinde cayma hakkı kullanılamaz. Cayma hakkının kullanımından kaynaklanan masraflar SATICI’ ya aittir. ALICI, iş bu sözleşmeyi kabul etmekle, cayma hakkı konusunda bilgilendirildiğini peşinen kabul eder.--}}
{{--<br>--}}
{{--7.2. Cayma hakkının kullanılması için 14 (ondört) günlük süre içinde SATICI' ya iadeli taahhütlü posta, faks veya eposta ile yazılı bildirimde bulunulması ve ürünün işbu sözleşmede düzenlenen düzenlenen "Cayma Hakkı Kullanılamayacak Ürünler" hükümleri çerçevesinde kullanılmamış olması şarttır. Bu hakkın kullanılması halinde,--}}
{{--<br>--}}
{{--7.2.1 3. kişiye veya ALICI’ ya teslim edilen ürünün faturası, (İade edilmek istenen ürünün faturası kurumsal ise, geri iade ederken kurumun düzenlemiş olduğu iade faturası ile birlikte gönderilmesi gerekmektedir. Faturası kurumlar adına düzenlenen sipariş iadeleri İADE FATURASI kesilmediği takdirde tamamlanamayacaktır.)--}}
{{--<br>--}}
{{--7.2.2. İade formu, <br>--}}
{{--7.2.3. İade edilecek ürünlerin kutusu, ambalajı, varsa standart aksesuarları ile birlikte eksiksiz ve hasarsız olarak teslim edilmesi gerekmektedir. <br>--}}
{{--7.2.4. SATICI, cayma bildiriminin kendisine ulaşmasından itibaren en geç 10 günlük süre içerisinde toplam bedeli ve ALICI’ yı borç altına sokan belgeleri ALICI’ ya iade etmek ve 20 günlük süre içerisinde malı iade almakla yükümlüdür.--}}
{{--<br>--}}
{{--7.2.5. ALICI’ nın kusurundan kaynaklanan bir nedenle malın değerinde bir azalma olursa veya iade imkânsızlaşırsa ALICI kusuru oranında SATICI’ nın zararlarını tazmin etmekle yükümlüdür. Ancak cayma hakkı süresi içinde malın veya ürünün usulüne uygun kullanılmasın sebebiyle meydana gelen değişiklik ve bozulmalardan ALICI sorumlu değildir.--}}
{{--<br>--}}
{{--7.2.6. Cayma hakkının kullanılması nedeniyle SATICI tarafından düzenlenen kampanya limit tutarının altına düşülmesi halinde kampanya kapsamında faydalanılan indirim miktarı iptal edilir.--}}
{{--<br>--}}
{{--<br>--}}
{{--8. CAYMA HAKKI KULLANILAMAYACAK ÜRÜNLER <br>--}}
{{--<br>--}}
{{--8.1. a) Fiyatı finansal piyasalardaki dalgalanmalara bağlı olarak değişen ve satıcı veya sağlayıcının kontrolünde olmayan mal veya hizmetlere ilişkin sözleşmeler. <br>--}}
{{--b) Tüketicinin istekleri veya kişisel ihtiyaçları doğrultusunda hazırlanan mallara ilişkin sözleşmeler. <br>--}}
{{--c) Çabuk bozulabilen veya son kullanma tarihi geçebilecek malların teslimine ilişkin sözleşmeler. <br>--}}
{{--ç) Tesliminden sonra ambalaj, bant, mühür, paket gibi koruyucu unsurları açılmış olan mallardan; iadesi sağlık ve hijyen açısından uygun olmayanların teslimine ilişkin sözleşmeler. <br>--}}
{{--d) Tesliminden sonra başka ürünlerle karışan ve doğası gereği ayrıştırılması mümkün olmayan mallara ilişkin sözleşmeler. <br>--}}
{{--e) Malın tesliminden sonra ambalaj, bant, mühür, paket gibi koruyucu unsurları açılmış olması halinde maddi ortamda sunulan kitap, dijital içerik ve bilgisayar sarf malzemelerine, veri kaydedebilme ve veri depolama cihazlarına  ilişkin sözleşmeler.--}}
{{--<br>--}}
{{--f) Abonelik sözleşmesi kapsamında sağlananlar dışında, gazete ve dergi gibi süreli yayınların teslimine ilişkin sözleşmeler. <br>--}}
{{--g) Belirli bir tarihte veya dönemde yapılması gereken, konaklama, eşya taşıma, araba kiralama, yiyecek-içecek tedariki ve eğlence veya dinlenme amacıyla yapılan boş zamanın değerlendirilmesine ilişkin sözleşmeler.--}}
{{--<br>--}}
{{--ğ) Elektronik ortamda anında ifa edilen hizmetler veya tüketiciye anında teslim edilen gayrimaddi mallara ilişkin sözleşmeler. <br>--}}
{{--h) Cayma hakkı süresi sona ermeden önce, tüketicinin onayı ile ifasına başlanan hizmetlere ilişkin sözleşmeler. <br>--}}
{{--Kozmetik ve kişisel bakım ürünleri, iç giyim ürünleri, mayo, bikini, kitap, kopyalanabilir yazılım ve programlar, DVD, VCD, CD ve kasetler ile kırtasiye sarf malzemeleri (toner, kartuş, şerit vb.) iade edilebilmesi için ambalajlarının açılmamış, denenmemiş, bozulmamış ve kullanılmamış olmaları gerekir.--}}
{{--<br>--}}
{{--8.2. SATICI şikâyet ve itirazları konusunda başvurularını,  aşağıdaki kanunda belirtilen parasal sınırlar dâhilinde tüketicinin yerleşim yerinin bulunduğu  veya tüketici işleminin yapıldığı yerdeki  tüketici sorunları hakem heyetine veya tüketici mahkemesine yapabilir. Parasal sınıra ilişkin bilgiler aşağıdadır:--}}
{{--<br>--}}
{{--28/05/2014 tarihinden itibaren geçerli olmak üzere: <br>--}}
{{--a) 6502 sayılı Tüketicinin Korunması Hakkında Kanun’un 68. Maddesi gereği değeri 2.000,00 (ikibin) TL’nin altında olan uyuşmazlıklarda ilçe tüketici hakem heyetlerine, <br>--}}
{{--b) Değeri 3.000,00(üçbin)TL’ nin altında bulunan uyuşmazlıklarda il tüketici hakem heyetlerine, <br>--}}
{{--c) Büyükşehir statüsünde bulunan illerde ise değeri 2.000,00 (ikibin) TL ile 3.000,00(üçbin)TL’  arasındaki uyuşmazlıklarda il tüketici hakem heyetlerine başvuru yapılmaktadır. <br>--}}
{{--İşbu Sözleşme ticari amaçlarla yapılmaktadır. <br>--}}
{{--<br>--}}
{{--SATICI: {{ $owner->full_name }}--}}
{{--<br>--}}
{{--ALICI: {{ $address->name . ' ' . $address->surname }}--}}
{{--<br>--}}
{{--TARİH: 09.12.19--}}
{{--<br>--}}
