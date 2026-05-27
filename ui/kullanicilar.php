<?php
require_once __DIR__ . '/../bl/KullaniciBL.php';
$bl = new KullaniciBL();
$mesaj = ""; $renk = "green";

// --- KULLANICI EKLE (`KullaniciEkle`) ---
if (isset($_POST['ekle'])) {
    $mesaj = $bl->yeniKullaniciEkle($_POST['ad'], $_POST['soyad'], $_POST['tel'], $_POST['email'], $_POST['sifre']);
    $renk = (strpos($mesaj, 'başarıyla') !== false) ? 'green' : 'red';
}
// --- KULLANICI SİL (`KullaniciSil`) ---
if (isset($_GET['action']) && $_GET['action'] == 'sil') {
    $bl->kullaniciSil($_GET['id']);
    header("Location: kullanicilar.php"); exit;
}
// --- KULLANICI GÜNCELLE (`KullaniciGuncelle`) ---
if (isset($_POST['guncelle'])) {
    $bl->kullaniciGuncelle($_POST['kullanici_id'], $_POST['ad'], $_POST['soyad'], $_POST['tel'], $_POST['email'], $_POST['sifre']);
    header("Location: kullanicilar.php"); exit;
}
$secilen = null;
if (isset($_GET['action']) && $_GET['action'] == 'duzenle') {
    foreach ($bl->tumKullanicilariGetir() as $k) {
        $vals = array_values($k);
        if ($vals[0] == $_GET['id']) { $secilen = $vals; break; }
    }
}
$list = $bl->tumKullanicilariGetir();
?>
<!DOCTYPE html>
<html lang="tr">
<head><meta charset="UTF-8"><title>Kullanıcılar</title></head>
<body style="margin:0; font-family:sans-serif; background:#f4f6f9;">
    <?php include 'menu.php'; ?>
    <div style="margin-left: 240px; padding: 20px;">
        <h2>👥 Kullanıcı Yönetimi Panel</h2>
        <?php if(!empty($mesaj)): ?><div style="background:<?=$renk?>; color:white; padding:10px; margin-bottom:10px; font-weight:bold;"><?= $mesaj ?></div><?php endif; ?>

        <?php if(!$secilen): ?>
        <div style="background:white; padding:15px; border:1px solid #ccc; margin-bottom:15px; max-width:400px;">
            <h3>➕ Yeni Kullanıcı Kaydet</h3>
            <form method="POST">
                <input type="text" name="ad" placeholder="Ad" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="text" name="soyad" placeholder="Soyad" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="text" name="tel" placeholder="Telefon" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="email" name="email" placeholder="E-posta" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="text" name="sifre" placeholder="Şifre" required style="width:100%; margin-bottom:5px; padding:5px;">
                <button type="submit" name="ekle" style="background:#28a745; color:white; border:none; padding:8px; cursor:pointer; width:100%;">Kullanıcı Ekle</button>
            </form>
        </div>
        <?php else: ?>
        <div style="background:white; padding:15px; border:1px solid #ffc107; margin-bottom:15px; max-width:400px;">
            <h3>📝 Kullanıcı Güncelle</h3>
            <form method="POST">
                <input type="hidden" name="kullanici_id" value="<?=$secilen[0]?>">
                <input type="text" name="ad" value="<?=$secilen[1]?>" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="text" name="soyad" value="<?=$secilen[2]?>" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="text" name="tel" value="<?=$secilen[3]?>" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="email" name="email" value="<?=$secilen[4]?>" required style="width:100%; margin-bottom:5px; padding:5px;">
                <input type="text" name="sifre" value="<?=$secilen[5]?>" required style="width:100%; margin-bottom:5px; padding:5px;">
                <button type="submit" name="guncelle" style="background:#ffc107; border:none; padding:8px; cursor:pointer; width:100%;">Değişiklikleri Kaydet</button>
            </form>
        </div>
        <?php endif; ?>

        <table border="1" cellpadding="8" style="width:100%; border-collapse:collapse; background:white;">
            <tr style="background:#f4f4f4;"><th>ID</th><th>Adı</th><th>Soyadı</th><th>Telefon</th><th>E-Posta</th><th>İşlemler</th></tr>
            <?php foreach($list as $k): $s = array_values($k); ?>
            <tr>
                <td><?=$s[0]?></td><td><?=$s[1]?></td><td><?=$s[2]?></td><td><?=$s[3]?></td><td><?=$s[4]?></td>
                <td>
                    <a href="kullanicilar.php?action=duzenle&id=<?=$s[0]?>" style="color:#31a2b8; font-weight:bold; margin-right:10px;">✏️ Düzenle</a>
                    <a href="kullanicilar.php?action=sil&id=<?=$s[0]?>" onclick="return confirm('Silinsin mi?')" style="color:red; font-weight:bold;">❌ Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>