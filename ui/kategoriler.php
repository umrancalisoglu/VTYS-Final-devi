<?php
require_once __DIR__ . '/../bl/KategoriBL.php';
$bl = new KategoriBL();

if(isset($_POST['kaydet'])) { $bl->yeniKategoriEkle($_POST['kategori_adi']); }
if(isset($_GET['sil'])) { 
    try {
        $db = new Database(); 
        $conn = $db->getConnection();
        $stmt = $conn->prepare("CALL KategoriSil(?)"); 
        $stmt->execute([$_GET['sil']]);
        header("Location: kategoriler.php"); exit; 
    } catch (PDOException $e) {
        $mesaj = "Hata: Veritabanında KategoriSil prosedürü bulunamadı! Lütfen önce SQL'e ekleyin.";
        $renk = "red";
    }
}
if(isset($_POST['guncelle_kat'])){
    $bl->kategoriGuncelle($_POST['kat_id'], $_POST['kategori_adi']);
    header("Location: kategoriler.php"); exit;
}
$secilenKat = null;
if(isset($_GET['action']) && $_GET['action'] == 'duzenle'){
    foreach($bl->tumKategorileriGetir() as $k){
        if($k['ID'] == $_GET['id']){ $secilenKat = $k; break; }
    }
}
$list = $bl->tumKategorileriGetir();
?>
<!DOCTYPE html>
<html lang="tr">
<head><meta charset="UTF-8"><title>Kategoriler</title></head>
<body style="margin:0; font-family:sans-serif; background:#f4f6f9;">
    <?php include 'menu.php'; ?>
    <div style="margin-left: 240px; padding: 20px;">
        <h2>📁 Kategori Yönetimi Panel</h2>
        
        <?php if(!$secilenKat): ?>
        <form method="POST" style="background:white; padding:15px; display:inline-block; border-radius:5px; border:1px solid #ccc;">
            <h3>➕ Yeni Kategori Ekle</h3>
            <input type="text" name="kategori_adi" required placeholder="Kategori Adı">
            <button type="submit" name="kaydet">Ekle</button>
        </form>
        <?php else: ?>
        <form method="POST" style="background:white; padding:15px; display:inline-block; border-radius:5px; border:1px solid #ffc107;">
            <h3>📝 Kategori Güncelle</h3>
            <input type="hidden" name="kat_id" value="<?=$secilenKat['ID']?>">
            <input type="text" name="kategori_adi" value="<?=$secilenKat['KategoriAdi']?>" required>
            <button type="submit" name="guncelle_kat">Güncelle</button>
        </form>
        <?php endif; ?>

        <table border="1" cellpadding="8" style="width:50%; border-collapse:collapse; background:white; margin-top:15px;">
            <tr style="background:#f4f4f4;"><th>ID</th><th>Kategori Adı</th><th>İşlemler</th></tr>
            <?php foreach($list as $k): ?>
            <tr>
                <td><?=$k['ID']?></td><td><?=$k['KategoriAdi']?></td>
                <td>
                    <a href="kategoriler.php?action=duzenle&id=<?=$k['ID']?>" style="color:#31a2b8; font-weight:bold; margin-right:10px;">✏️ Düzenle</a>
                    <a href="kategoriler.php?sil=<?=$k['ID']?>" onclick="return confirm('Silinsin mi?')" style="color:red; font-weight:bold;">❌ Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>