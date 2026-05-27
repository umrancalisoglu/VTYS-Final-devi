<?php
require_once __DIR__ . '/../dal/KategoriDAL.php';

class KategoriBL {
    private $dal;
    public function __construct() { $this->dal = new KategoriDAL(); }

    public function yeniKategoriEkle($ad) {
        if(empty($ad)) return "Kategori adı boş olamaz!";
        return $this->dal->kategoriEkle($ad) ? "Kategori başarıyla eklendi." : "Bir hata oluştu.";
    }

    public function kategoriGuncelle($id, $ad) {
        if(empty($id) || empty($ad)) return "Eksik bilgi!";
        return $this->dal->kategoriGuncelle($id, $ad) ? "Kategori güncellendi." : "Hata!";
    }

    public function tumKategorileriGetir() { return $this->dal->kategoriListele(); }
}
?>