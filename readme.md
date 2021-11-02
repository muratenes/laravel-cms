**Nedir ?**


Laravel ile yazılmış CMS ve eticaret sistemidir. Yönetim paneli üzerinden ihtiyaçlarınıza göre özelleştirebilirsiniz
İyzico ile ödeme işlemi yapar. Dil desteği ve para birimi desteği vardır

**Ayarları Nasıl değiştirebilirim ?**

Dosya içerisinden modüllerin aktiflik durumlarını sayfanın başlıklarını değiştirebilirsiniz. bazı ayarları aşağıda paylaştım

**config/admin.php**

    'title' => 'CMS',
    'short_title' => 'CMS',
    // module status
    'module_status' => [
        'banner' => true,
        'blog' => true,
        'coupon' => true,
        'content_management' => true,
        'contact' => true,
        'campaign' => true,
        'e_bulten' => true,
        'gallery' => true,
        'order' => true,
        'product' => true,
        'log' => true,
        'sss' => true,
        'setting' => true,
        'reference' => true,
        'user' => true,
        'our_team' => false
    ],`


Örnek Ekran görüntüleri

![alt text](https://i.ibb.co/zhgPNGY/sc2.png)

![alt text](https://i.ibb.co/rtr62PS/sc1.png)




**Run Local**

laravel-echo-server start
sudo npm run dev
pa serve --host=0.0.0.0 --port=8000


**redis hataları**

env dosyasından 6001 portunu okuyamadığında bu oluşur
redis testi için /redis veya host:6001


**storage hatası**

sudo chown -R www-data:www-data storage


**php composer hatası**

sudo apt-get update
sudo apt install php-xml
udo apt-get install php-mbstring



**Please make sure the PHP Redis extension is installed and enabled.**


nano /etc/php/7.4/cli/php.ini dosyasına
extension=redis.so ekle
