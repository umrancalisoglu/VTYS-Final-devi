<?php
require_once __DIR__ . '/../config/database.php';

class IlanDAL {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // --- KAYIP İLANLARI ---
    public function kayipIlanEkle($tarih, $konum, $durum, $kullanici_id, $esya_id) {
        try {
            $query = "CALL KayipIlanEkle(?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $tarih);
            $stmt->bindParam(2, $konum);
            $stmt->bindParam(3, $durum);
            $stmt->bindParam(4, $kullanici_id);
            $stmt->bindParam(5, $esya_id);
            $stmt->execute();
            return ["success" => true, "message" => "Kayıp ilanı başarıyla eklendi!"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function kayipIlanGuncelle($id, $tarih, $konum, $durum) {
        $query = "CALL KayipIlanGuncelle(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $tarih);
        $stmt->bindParam(3, $konum);
        $stmt->bindParam(4, $durum);
        return $stmt->execute();
    }

    public function kayipIlanSil($id) {
        $query = "CALL KayipIlanSil(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function kayipIlanlariListele() {
        $query = "CALL KayipIlanListele()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- BULUNDU İLANLARI ---
    public function bulunduIlanEkle($tarih, $konum, $kullanici_id, $esya_id) {
        $query = "CALL BulunduIlanEkle(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $tarih);
        $stmt->bindParam(2, $konum);
        $stmt->bindParam(3, $kullanici_id);
        $stmt->bindParam(4, $esya_id);
        return $stmt->execute();
    }

    public function bulunduIlanGuncelle($id, $tarih, $konum) {
        $query = "CALL BulunduIlanGuncelle(?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $tarih);
        $stmt->bindParam(3, $konum);
        return $stmt->execute();
    }

    public function bulunduIlanSil($id) {
        $query = "CALL BulunduIlanSil(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function bulunduIlanlariListele() {
        $query = "CALL BulunduIlanListele()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- FONKSİYONLAR ---
    public function getIlanGunSayisi($ilan_id) {
        $query = "SELECT fn_ilan_kac_gun(?) AS gun";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $ilan_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['gun'] ?? 0;
    }
}
?>