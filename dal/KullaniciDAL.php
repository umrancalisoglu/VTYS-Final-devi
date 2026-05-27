<?php
require_once __DIR__ . '/../config/database.php';

class KullaniciDAL {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function kullaniciEkle($ad, $soyad, $tel, $email, $sifre) {
        $query = "CALL KullaniciEkle(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $ad);
        $stmt->bindParam(2, $soyad);
        $stmt->bindParam(3, $tel);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $sifre);
        return $stmt->execute();
    }

    public function kullaniciGuncelle($id, $ad, $soyad, $tel, $email, $sifre) {
        $query = "CALL KullaniciGuncelle(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $ad);
        $stmt->bindParam(3, $soyad);
        $stmt->bindParam(4, $tel);
        $stmt->bindParam(5, $email);
        $stmt->bindParam(6, $sifre);
        return $stmt->execute();
    }

    public function kullaniciSil($id) {
        $query = "CALL KullaniciSil(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function kullaniciListele() {
        $query = "CALL KullaniciHepsi()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>