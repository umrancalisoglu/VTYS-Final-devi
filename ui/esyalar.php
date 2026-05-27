<?php
require_once __DIR__ . '/../bl/EsyaBL.php';
require_once __DIR__ . '/../bl/KategoriBL.php';
$esyaBL = new EsyaBL(); $katBL = new KategoriBL();
$mesaj = "";

if(isset($_POST['kaydet'])) { $mesaj = $esyaBL->yeniEsyaEkle($_POST['ad'], $_POST['kategori_id'], $_POST['aciklama']); }
if(isset($_GET['sil'])) { $esyaBL->esyaSil($_GET['sil']); header("Location: esyalar.php"); exit; }
if(isset($_POST['guncelle_esya'])){
    $esyaBL->esyaGuncelle($_POST['esya_id'], $_POST['ad'], $_POST['kategori_id'], $_POST['aciklama']);
    header("Location: esyalar.php"); exit;
}
$secilenEsya = null;
if(isset($_GET['action']) && $_GET['action'] == 'duzenle'){
    foreach($esyaBL->tumEsyalariGetir() as $e){
        if($e['ID'] == $_GET['id']){ $secilenEsya = $e; break; }
    }
}
$esyalar = $esyaBL->tumEsyalariGetir(); $kategoriler = $katBL->tumKategorileriGetir();
?>
<!DOCTYPE html>
<html lang="tr">
<head><meta charset="UTF-8"><title>Eşyalar</title></head>
<body style="margin:0; font-family:sans-serif; background:#f4f6f9;">
    <?php include 'menu.php'; ?>
    <div style="margin-left: 240px; padding: 20px;">
        <h2>📦 Eşya Havuzu Yönetimi Panel</h2>
        
        <?php if(!$secilenEsya): ?>
        <form method="POST" style="background:white; padding:15px; border-radius:5px; max-width:400px; border:1px solid #ccc;">
            <h3>➕ Yeni Eşya Tanımla</h3>
            <input type="text" name="ad" placeholder="Eşya Adı" style="width:100%; margin-bottom:5px;" required>
            <select name="kategori_id" style="width:100%; margin-bottom:5px;" required>
                <?php foreach($kategoriler as $k): ?><option value="<?=$k['ID']?>"><?=$k['KategoriAdi']?></option><?php endforeach; ?>
            </select>
            <textarea name="aciklama" placeholder="Açıklama" style="width:100%; margin-bottom:5px;" required></textarea>
            <button type="submit" name="kaydet" style="width:100%; background:#28a745; color:white; border:none; padding:5px;">Ekle</button>
        </form>
        <?php else: ?>
        <form method="POST" style="background:white; padding:15px; border-radius:5px; max-width:400px; border:1px solid #ffc107;">
            <h3>📝 Eşya Güncelle</h3>
            <input type="hidden" name="esya_id" value="<?=$secilenEsya['ID']?>">
            <input type="text" name="ad" value="<?=$secilenEsya['EsyaAdi']?>" style="width:100%; margin-bottom:5px;" required>
            <select name="kategori_id" style="width:100%; margin-bottom:5px;" required>
                <?php foreach($kategoriler as $k): ?><option value="<?=$k['ID']?>" <?=$k['KategoriAdi']==$secilenEsya['Kategori']?'selected':''?>><?=$k['KategoriAdi']?></option><?php endforeach; ?>
            </select>
            <textarea name="aciklama" style="width:100%; margin-bottom:5px;" required><?=$secilenEsya['Aciklama']?></textarea>
            <button type="submit" name="guncelle_esya" style="width:100%; background:#ffc107; border:none; padding:5px;">Güncelle</button>
        </form>
        <?php endif; ?>

        <table border="1" cellpadding="8" style="width:100%; border-collapse:collapse; background:white; margin-top:15px;">
            <tr style="background:#f4f4f4;"><th>ID</th><th>Eşya Adı</th><th>Kategori</th><th>Açıklama</th><th>İşlemler</th></tr>
            <?php foreach($esyalar as $e): ?>
            <tr>
                <td><?=$e['ID']?></td><td><?=$e['EsyaAdi']?></td><td><?=$e['Kategori']?></td><td><?=$e['Aciklama']?></td>
                <td>
                    <a href="esyalar.php?action=duzenle&id=<?=$e['ID']?>" style="color:#31a2b8; font-weight:bold; margin-right:10px;">✏️ Düzenle</a>
                    <a href="esyalar.php?sil=<?=$e['ID']?>" onclick="return confirm('Silinsin mi?')" style="color:red; font-weight:bold;">❌ Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>