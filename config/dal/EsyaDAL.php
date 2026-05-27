<?php
require_once __DIR__ . '/../config/database.php';

class EsyaDAL {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function esyaEkle($ad, $kategori_id, $aciklama) {
        $query = "CALL EsyaEkle(?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $ad);
        $stmt->bindParam(2, $kategori_id);
        $stmt->bindParam(3, $aciklama);
        return $stmt->execute();
    }

    public function esyaGuncelle($id, $ad, $kategori_id, $aciklama) {
        $query = "CALL EsyaGuncelle(?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $ad);
        $stmt->bindParam(3, $kategori_id);
        $stmt->bindParam(4, $aciklama);
        return $stmt->execute();
    }

    public function esyaSil($id) {
        $query = "CALL EsyaSil(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    public function esyaListele() {
        $query = "CALL EsyaListele()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>