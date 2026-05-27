<?php
require_once __DIR__ . '/../dal/KullaniciDAL.php';

class KullaniciBL {
    private $dal;
    public function __construct() { $this->dal = new KullaniciDAL(); }

    public function yeniKullaniciEkle($ad, $soyad, $tel, $email, $sifre) {
        if(empty($ad) || empty($soyad) || empty($email)) return "Eksik bilgi!";
        return $this->dal->kullaniciEkle($ad, $soyad, $tel, $email, $sifre) ? "Kullanıcı eklendi." : "Hata!";
    }

    public function kullaniciGuncelle($id, $ad, $soyad, $tel, $email, $sifre) {
        return $this->dal->kullaniciGuncelle($id, $ad, $soyad, $tel, $email, $sifre);
    }

    public function kullaniciSil($id) { return $this->dal->kullaniciSil($id); }
    public function tumKullanicilariGetir() { return $this->dal->kullaniciListele(); }
}
?>