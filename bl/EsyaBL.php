<?php
require_once __DIR__ . '/../dal/EsyaDAL.php';

class EsyaBL {
    private $dal;
    public function __construct() { $this->dal = new EsyaDAL(); }

    public function yeniEsyaEkle($ad, $kategori_id, $aciklama) {
        if(empty($ad) || empty($kategori_id)) return "Eksik bilgi!";
        return $this->dal->esyaEkle($ad, $kategori_id, $aciklama) ? "Eşya eklendi." : "Hata!";
    }

    public function esyaGuncelle($id, $ad, $kategori_id, $aciklama) {
        return $this->dal->esyaGuncelle($id, $ad, $kategori_id, $aciklama) ? "Eşya güncellendi." : "Hata!";
    }

    public function esyaSil($id) { return $this->dal->esyaSil($id); }
    public function tumEsyalariGetir() { return $this->dal->esyaListele(); }
}
?>