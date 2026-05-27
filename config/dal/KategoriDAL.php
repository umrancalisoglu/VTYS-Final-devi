<?php
require_once __DIR__ . '/../config/database.php';

class KategoriDAL {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function kategoriEkle($kategori_adi) {
        $query = "CALL KategoriEkle(?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $kategori_adi);
        return $stmt->execute();
    }

    public function kategoriGuncelle($id, $kategori_adi) {
        $query = "CALL KategoriGuncelle(?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $kategori_adi);
        return $stmt->execute();
    }

    public function kategoriListele() {
        $query = "CALL KategoriListele()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>