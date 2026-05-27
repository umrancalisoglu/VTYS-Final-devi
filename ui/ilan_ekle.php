<?php
require_once __DIR__ . '/../bl/IlanBL.php';
require_once __DIR__ . '/../bl/KullaniciBL.php';

$ilanBL = new IlanBL();
$kullaniciBL = new KullaniciBL();

$kullaniciListesi = $kullaniciBL->tumKullanicilariGetir();

$mesaj = "";
$renk = "green";

if (isset($_POST['ilan_kaydet'])) {
    $konum = $_POST['konum'];
    $durum = $_POST['durum'];
    $kullanici_id = $_POST['kullanici_id'];
    $esya_id = $_POST['esya_id'];

    $sonuc = $ilanBL->yeniKayipIlanEkle($konum, $durum, $kullanici_id, $esya_id);
    
    $mesaj = $sonuc['message'];
    $renk = $sonuc['success'] ? 'green' : 'red';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>KayıpBul - İlan Ekle</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .form-box { max-width: 400px; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select, button { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; cursor: pointer; }
        .alert { padding: 10px; margin-bottom: 15px; color: white; font-weight: bold; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Yeni Kayıp İlanı Ekle </h2>

        <?php if(!empty($mesaj)): ?>
            <div class="alert" style="background-color: <?php echo $renk; ?>;">
                Sistem Mesajı: <?php echo $mesaj; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label>Kullanıcı Seçin:</label>
            <select name="kullanici_id" required>
                <?php foreach($kullaniciListesi as $k): ?>
                    <option value="<?php echo $k['ID']; ?>"><?php echo $k['Adı']." ".$k['Soyadı']; ?></option>
                <?php endforeach; ?>
            </select>

            <label>Eşya ID:</label>
            <input type="number" name="esya_id" placeholder="Örn: 1" required>

            <label>Konum:</label>
            <input type="text" name="konum" placeholder="Örn: İstanbul Merkez" required>

            <label>Durum:</label>
            <select name="durum">
                <option value="Kayıp">Kayıp</option>
                <option value="İnceleniyor">İnceleniyor</option>
            </select>

            <br><br>
            <button type="submit" name="ilan_kaydet">İlan Ekle</button>
        </form>
        <br>
        <a href="index.php">← Listeye Dön</a>
    </div>
</body>
</html>