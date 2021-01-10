 **Run Local**
 
 laravel-echo-server start
 sudo npm run dev
pa serve --host=0.0.0.0 --port=8000


**redis hataları**

env dosyasından 6001 portunu okuyamadığında bu oluşur
redis testi için /redis veya 127.0.0.1:6001


**storage hatası** 

sudo chown -R www-data:www-data storage


**php composer hatası**

sudo apt-get update
sudo apt install php-xml
udo apt-get install php-mbstring



**Please make sure the PHP Redis extension is installed and enabled.**


nano /etc/php/7.4/cli/php.ini dosyasına 
extension=redis.so ekle
