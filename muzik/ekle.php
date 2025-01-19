<?php
require_once "config.php";

// Yeni müzik ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_muzik'])) {
    $isim = $_POST['isim'];
    $fotoğraf = $_FILES['fotoğraf']['name'];
    $başlık = $_POST['başlık'];
    $ses_dosyası = $_FILES['ses_dosyası']['name'];

    // Dosyaları yükleme
    move_uploaded_file($_FILES['fotoğraf']['tmp_name'], "img/$fotoğraf");
    move_uploaded_file($_FILES['ses_dosyası']['tmp_name'], "audio/$ses_dosyası");

    // Veritabanına ekleme
    $query = "INSERT INTO muzikler (isim, fotoğraf, başlık, ses_dosyası) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $isim, $fotoğraf, $başlık, $ses_dosyası);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminMuzik.php"); // Başarıyla ekledikten sonra adminMuzik.php'ye yönlendir
        exit;
    } else {
        echo "Hata: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stilAdmin.css">
    <title>Yeni Müzik Ekle</title>
</head>
<body>
    <div class="container">
    <?php include("slidebar.php"); ?>
        <main class="content">
            <center><h2>Yeni Müzik Ekle</h2></center>
            <div class="form-container">
    <form action="ekle.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="isim" placeholder="Müzik İsmi" required><br>
        <input type="file" name="fotoğraf" accept="image/*" required><br>
        <input type="text" name="başlık" placeholder="Başlık" required><br>
        <input type="file" name="ses_dosyası" accept="audio/*" required><br>
        <button type="submit" name="add_muzik">Ekle</button>
    </form>
</div>

            </form>
        </main>
    </div>
</body>
</html>
