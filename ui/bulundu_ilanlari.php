<?php
require_once __DIR__ . '/../bl/IlanBL.php';
require_once __DIR__ . '/../bl/KullaniciBL.php';
$ilanBL = new IlanBL(); $kullaniciBL = new KullaniciBL();
$mesaj = "";

if (isset($_POST['bulundu_kaydet'])) {
    $sonuc = $ilanBL->yeniBulunduIlanEkle($_POST['konum'], $_POST['kullanici_id'], $_POST['esya_id']);
    $mesaj = $sonuc['message'];
}
if (isset($_GET['sil'])) {
    $ilanBL->bulunduIlanSil($_GET['sil']);
    header("Location: bulundu_ilanlari.php"); exit;
}
if(isset($_POST['guncelle_bulundu'])){
    $ilanBL->bulunduIlanGuncelle($_POST['ilan_id'], date("Y-m-d H:i:s"), $_POST['konum']);
    header("Location: bulundu_ilanlari.php"); exit;
}
$secilenBulundu = null;
if(isset($_GET['action']) && $_GET['action'] == 'duzenle'){
    foreach($ilanBL->tumBulunduIlanlariGetir() as $b){
        if($b['ID'] == $_GET['id']){ $secilenBulundu = $b; break; }
    }
}
$list = $ilanBL->tumBulunduIlanlariGetir();
$kullanicilar = $kullaniciBL->tumKullanicilariGetir();
?>
<!DOCTYPE html>
<html lang="tr">
<head><meta charset="UTF-8"><title>Bulundu İlanları</title></head>
<body style="margin:0; font-family:sans-serif; background:#f4f6f9;">
    <?php include 'menu.php'; ?>
    <div style="margin-left: 240px; padding: 20px;">
        <h2>✅ Bulundu İlanları Yönetim Paneli</h2>
        <?php if(!empty($mesaj)): ?><div style="background:green; color:white; padding:10px; margin-bottom:10px;"><?= $mesaj ?></div><?php endif; ?>

        <?php if(!$secilenBulundu): ?>
        <div style="background:white; padding:15px; border:1px solid #ccc; margin-bottom:15px; max-width:400px;">
            <h3>➕ Yeni Bulundu İlanı Bildir</h3>
            <form method="POST">
                <input type="number" name="esya_id" placeholder="Eşya ID" required style="width:100%; margin-bottom:5px;">
                <select name="kullanici_id" style="width:100%; margin-bottom:5px;">
                    <?php foreach($kullanicilar as $k): $kv = array_values($k); ?><option value="<?=$kv[0]?>"><?=$kv[1]?></option><?php endforeach; ?>
                </select>
                <input type="text" name="konum" placeholder="Bulunan Konum" required style="width:100%; margin-bottom:5px;">
                <button type="submit" name="bulundu_kaydet" style="background:#28a745; color:white; border:none; width:100%; padding:5px; cursor:pointer;">Yayınla</button>
            </form>
        </div>
        <?php else: ?>
        <div style="background:white; padding:15px; border:1px solid #ffc107; margin-bottom:15px; max-width:400px;">
            <h3>📝 Bulundu İlanı Güncelle</h3>
            <form method="POST">
                <input type="hidden" name="ilan_id" value="<?=$secilenBulundu['ID']?>">
                <label>Yeni Konum:</label><input type="text" name="konum" value="<?=$secilenBulundu['Konum']?>" required style="width:100%; margin-bottom:10px;">
                <button type="submit" name="guncelle_bulundu" style="background:#ffc107; width:100%; padding:5px; cursor:pointer;">Güncelle</button>
            </form>
        </div>
        <?php endif; ?>

        <table border="1" cellpadding="8" style="width:100%; border-collapse:collapse; background:white;">
            <tr style="background:#f4f4f4;">
                <th>İlan ID</th>
                <th>Bulunan Eşya</th>
                <th>Eşyayı Bulan Kişi Bilgileri</th>
                <th>Bulunduğu Konum</th>
                <th>İlan Tarihi</th>
                <th>İşlemler</th>
            </tr>
            <?php if(!empty($list)): ?>
                <?php foreach($list as $b): ?>
                <tr>
                    <td><b><?=$b['ID']?></b></td>
                    <td style="color:#27ae60; font-weight:bold;"><?=$b['EsyaAdi']?></td>
                    <td>
                        <b><?=$b['KullaniciAdi']." ".$b['KullaniciSoyadi']?></b><br>
                        <small style="color:#555;">📞 Tel: <?=$b['KullaniciTel'] ?? 'Belirtilmemiş'?></small><br>
                        <small style="color:#555;">✉️ E-posta: <?=$b['KullaniciEmail'] ?? 'Belirtilmemiş'?></small>
                    </td>
                    <td><?=$b['Konum']?></td>
                    <td><?=$b['Tarih']?></td>
                    <td>
                        <a href="bulundu_ilanlari.php?action=duzenle&id=<?=$b['ID']?>" style="color:#31a2b8; font-weight:bold; margin-right:10px; text-decoration:none;">✏️ Düzenle</a>
                        <a href="bulundu_ilanlari.php?sil=<?=$b['ID']?>" onclick="return confirm('Silinsin mi?')" style="color:red; font-weight:bold; text-decoration:none;">❌ Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">Henüz bildirilmiş bulundu ilanı yok.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>