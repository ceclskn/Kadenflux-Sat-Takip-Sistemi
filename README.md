# KadenFlux - Satış Takip Sistemi

Bu proje, KadenFlux adlı basit bir satış takip sistemidir. Sistem, kullanıcı girişi, satış ekleme, düzenleme ve listeleme gibi temel işlevleri sağlar.

## Özellikler

- Ürün ekleme ve listeleme
- Satış kaydı oluşturma
- Kullanıcı girişi
- MySQL veritabanı ile veri yönetimi
- Temel güvenlik kontrolleri

## Kullanılan Teknolojiler

- PHP
- MySQL
- HTML/CSS
- phpMyAdmin (veritabanı yönetimi)

## Kurulum

1. Veritabanını oluşturun:
   - `phpMyAdmin` üzerinden `.sql`uzantılı dosyaları içe aktararak gerekli tabloları oluşturun.

2. `config.php` dosyasındaki veritabanı bağlantı bilgilerini kendi sunucunuza göre güncelleyin:

   ```php
   $host = 'localhost'; // ya da uzak sunucu IP adresi
   $db = 'veritabani_adi';
   $user = 'kullanici_adi';
   $pass = 'sifre';





(Bu proje ceclskn tarafından BTU Bilgisayar Mühendisliği dersi kapsamında geliştirilmiştir.)
