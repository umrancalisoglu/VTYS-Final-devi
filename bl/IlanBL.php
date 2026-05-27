<?php
require_once __DIR__ . '/../dal/IlanDAL.php';

class IlanBL {
    private $dal;
    
    public function __construct() { 
        $this->dal = new IlanDAL(); 
    }

    // --- KAYIP İLAN SÜREÇLERİ ---
    public function yeniKayipIlanEkle($konum, $durum, $kullanici_id, $esya_id) {
        if(empty($konum) || empty($kullanici_id) || empty($esya_id)) {
            return ["success" => false, "message" => "Lütfen zorunlu alanları doldurun!"];
        }
        return $this->dal->kayipIlanEkle(date("Y-m-d H:i:s"), $konum, $durum, $kullanici_id, $esya_id);
    }

    public function kayipIlanGuncelle($id, $tarih, $konum, $durum) {
        if(empty($id) || empty($konum) || empty($durum)) {
            return false;
        }
        // DAL katmanındaki kayipIlanGuncelle Stored Procedure çağrısını tetikliyoruz
        return $this->dal->kayipIlanGuncelle($id, $tarih, $konum, $durum);
    }

    public function kayipIlanSil($id) { 
        return $this->dal->kayipIlanSil($id); 
    }

    public function tumKayipIlanlariGetir() {
        $ilanlar = $this->dal->kayipIlanlariListele();
        foreach ($ilanlar as $key => $ilan) {
            $ilanlar[$key]['KacGunOldu'] = $this->dal->getIlanGunSayisi($ilan['ID']);
        }
        return $ilanlar;
    }

    // --- BULUNDU İLAN SÜREÇLERİ ---
    public function yeniBulunduIlanEkle($konum, $kullanici_id, $esya_id) {
        if(empty($konum) || empty($kullanici_id) || empty($esya_id)) {
            return ["success" => false, "message" => "Lütfen tüm alanları doldurun!"];
        }
        $tarih = date("Y-m-d H:i:s");
        $sonuc = $this->dal->bulunduIlanEkle($tarih, $konum, $kullanici_id, $esya_id);
        
        if($sonuc) {
            return ["success" => true, "message" => "Bulundu ilanı başarıyla sisteme kaydedildi!"];
        } else {
            return ["success" => false, "message" => "İlan eklenirken bir veritabanı hatası oluştu."];
        }
    }

    // Bulundu ilan güncellemesi için de arayüzden gelebilecek çağrıyı garantiye aldık
    public function bulunduIlanGuncelle($id, $tarih, $konum) {
        if(empty($id) || empty($konum)) {
            return false;
        }
        return $this->dal->bulunduIlanGuncelle($id, $tarih, $konum);
    }

    public function bulunduIlanSil($id) { 
        return $this->dal->bulunduIlanSil($id); 
    }

    public function tumBulunduIlanlariGetir() { 
        return $this->dal->bulunduIlanlariListele(); 
    }
}
?>