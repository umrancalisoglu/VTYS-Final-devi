# VTYS-Final-Ödevi
# 🔍 N-Katmanlı Mimari ile Kayıp Eşya Yönetim Sistemi

Bu proje, veritabanı yönetim sistemleri dönem ödevi şartnamesine tam uyumlu olarak **N-Katmanlı Mimari (N-Tier Architecture)** prensipleriyle geliştirilmiş web tabanlı bir **Kayıp-Bulundu Eşya Takip Otomasyonu**dur. 

Sistemde güvenlik ve performans standartları gereği hiçbir arayüz katmanında ham SQL sorgusu kullanılmamış, tüm CRUD süreçleri **Stored Procedure (Saklı Yordamlar)** üzerinden yönetilmiştir.

---

## 🏗️ Proje Mimarisi (N-Tier Layers)
Proje 3 temel mantıksal katmandan oluşmaktadır:
1. **Presentation Layer (UI):** Kullanıcının etkileşime girdiği, formların ve listeleme tablolarının yer aldığı PHP arayüz katmanı.
2. **Business Layer (BL):** İş kurallarının, doğrulama mekanizmalarının ve süreç yönetiminin kontrol edildiği iş mantığı katmanı.
3. **Data Access Layer (DAL):** Veritabanı bağlantısının kurulduğu ve sadece `Stored Procedure` çağrılarının icra edildiği veri erişim katmanı.

---

## 🛠️ Kullanılan Gelişmiş Veritabanı Nesneleri

### 1. Stored Procedures (Saklı Yordamlar)
Sistemdeki tüm veri modülleri (`Kullanıcılar`, `Kayıp İlanları`, `Bulundu İlanları`, `Eşya Havuzu`, `Kategoriler`) için **Ekle, Sil, Güncelle ve Listele** işlemleri özel prosedürlerle yapılmıştır:
* `KullaniciEkle`, `KullaniciSil`, `KullaniciGuncelle`, `KullaniciHepsi`
* `KayipIlanListele`, `KayipIlanGuncelle`, `KayipIlanSil`, `KayipIlanEkle`
* `BulunduIlanListele`, `BulunduIlanGuncelle`, `BulunduIlanSil`, `BulunduIlanEkle`
* `EsyaEkle`, `EsyaGuncelle`, `EsyaSil`, `EsyaListele`
* `KategoriEkle`, `KategoriGuncelle`, `KategoriSil`, `KategoriListele`

### 2. Triggers (Tetikleyiciler) & Functions (Fonksiyonlar)
* **Trigger:** Yeni bir ilan girişi veya durum değişikliği anında arka planda otomatik loglama veya ilişki kontrolü sağlayan tetikleyiciler aktiftir.(`tg_kayip_ilan_kontrol`, `tg_bulunan_esya_kontrol`)
* **Scalar Function:** İlanların sisteme girildiği andan itibaren geçen süreyi dinamik olarak gün bazında hesaplayan (`fn_ilan_kac_gun`) veritabanı fonksiyonu ve eşya durumu için 'Bulundu - Kayıp' döndüren (`fn_esya_durumu`) veritabanı fonksiyonu entegre edilmiştir.

---

## 🚀 Kurulum ve Çalıştırma
1. Bu depoyu `git clone` ile bilgisayarınıza indirin veya `.zip` olarak çıkarın.
2. Klasörü XAMPP içindeki `htdocs/kayipesya` dizinine taşıyın.
3. `phpMyAdmin` panelinden `kayip_esya` adında bir veritabanı oluşturun ve kök dizindeki `veritabanı.sql` dosyasını içeri aktarın (Import).
4. Tarayıcınızdan `http://localhost/kayipesya/ui/index.php` adresine giderek sistemi çalıştırabilirsiniz.

   
