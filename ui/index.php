<?php
require_once __DIR__ . '/../bl/IlanBL.php';
$bl = new IlanBL();

if(isset($_GET['sil'])){
    $bl->kayipIlanSil($_GET['sil']);
    header("Location: index.php"); exit;
}
if(isset($_POST['guncelle_ilan'])){
    $bl->kayipIlanGuncelle($_POST['ilan_id'], date("Y-m-d H:i:s"), $_POST['konum'], $_POST['durum']);
    header("Location: index.php"); exit;
}
$secilenIlan = null;
if(isset($_GET['action']) && $_GET['action'] == 'duzenle'){
    foreach($bl->tumKayipIlanlariGetir() as $ilan){
        if($ilan['ID'] == $_GET['id']){ $secilenIlan = $ilan; break; }
    }
}
$list = $bl->tumKayipIlanlariGetir();
?>
<!DOCTYPE html>
<html lang="tr">
<head><meta charset="UTF-8"><title>Kayıp İlanları</title></head>
<body style="margin:0; font-family:sans-serif; background:#f4f6f9;">
    <?php include 'menu.php'; ?>
    <div style="margin-left: 240px; padding: 20px;">
        <h2>📋 Kayıp İlanları Yönetim Paneli</h2>
        <a href="ilan_ekle.php" style="background:#007bff; color:white; padding:6px 12px; text-decoration:none; border-radius:4px; font-weight:bold;">+ Yeni Kayıp İlanı Ekle</a>
        <br><br>

        <?php if($secilenIlan): ?>
        <div style="background:white; padding:15px; border:1px solid #ffc107; margin-bottom:15px; max-width:400px;">
            <h3>📝 Kayıp İlanı Güncelle</h3>
            <form method="POST">
                <input type="hidden" name="ilan_id" value="<?=$secilenIlan['ID']?>">
                <label>Konum:</label><input type="text" name="konum" value="<?=$secilenIlan['Konum']?>" required style="width:100%; margin-bottom:5px;"><br>
                <label>Durum:</label>
                <select name="durum" style="width:100%; margin-bottom:10px;">
                    <option value="Kayıp" <?=$secilenIlan['Durum']=='Kayıp'?'selected':''?>>Kayıp</option>
                    <option value="İnceleniyor" <?=$secilenIlan['Durum']=='İnceleniyor'?'selected':''?>>İnceleniyor</option>
                </select>
                <button type="submit" name="guncelle_ilan" style="background:#ffc107; width:100%; padding:5px; cursor:pointer;">Değişiklikleri Kaydet</button>
            </form>
        </div>
        <?php endif; ?>

        <table border="1" cellpadding="8" style="width:100%; border-collapse:collapse; background:white;">
            <tr style="background:#f4f4f4;">
                <th>ID</th>
                <th>Kaybolan Eşya</th>
                <th>İlanı Veren Kişi Bilgileri</th>
                <th>Kayıp Konumu</th>
                <th>Sistem Süresi</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
            <?php foreach($list as $i): ?>
            <tr>
                <td><b><?=$i['ID']?></b></td>
                <td style="color:#c0392b; font-weight:bold;"><?=$i['EsyaAdi']?></td>
                <td>
                    <b><?=$i['KullaniciAdi']." ".$i['KullaniciSoyadi']?></b><br>
                    <small style="color:#555;">📞 Tel: <?=$i['KullaniciTel'] ?? 'Belirtilmemiş'?></small><br>
                    <small style="color:#555;">✉️ E-posta: <?=$i['KullaniciEmail'] ?? 'Belirtilmemiş'?></small>
                </td>
                <td><?=$i['Konum']?></td>
                <td style="color:blue; font-weight:bold;"><?=$i['KacGunOldu']?> gün önce</td>
                <td><span style="background:#e67e22; color:white; padding:3px 8px; border-radius:10px; font-size:12px;"><?=$i['Durum']?></span></td>
                <td>
                    <a href="index.php?action=duzenle&id=<?=$i['ID']?>" style="color:#31a2b8; font-weight:bold; margin-right:10px; text-decoration:none;">✏️ Düzenle</a>
                    <a href="index.php?sil=<?=$i['ID']?>" onclick="return confirm('Silinsin mi?')" style="color:red; font-weight:bold; text-decoration:none;">❌ Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>