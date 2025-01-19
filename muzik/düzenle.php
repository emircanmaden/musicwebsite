<?php
require_once "config.php";

// Düzenlenecek müzik ID'si
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM muzikler WHERE id = $id";
    $result = mysqli_query($link, $query);
    $muzik = mysqli_fetch_assoc($result);
} else {
    // Yeni müzik ekleme işlemi
    $muzik = ['id' => '', 'isim' => '', 'fotoğraf' => '', 'başlık' => '', 'ses_dosyası' => ''];
}

// Müzik güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_muzik'])) {
    $isim = $_POST['isim'];
    $fotoğraf = $_FILES['fotoğraf']['name'] ? $_FILES['fotoğraf']['name'] : $muzik['fotoğraf'];
    $başlık = $_POST['başlık'];
    $ses_dosyası = $_FILES['ses_dosyası']['name'] ? $_FILES['ses_dosyası']['name'] : $muzik['ses_dosyası'];

    // Dosyaları yedekleme
    if ($_FILES['fotoğraf']['name']) {
        move_uploaded_file($_FILES['fotoğraf']['tmp_name'], "img/$fotoğraf");
    }
    if ($_FILES['ses_dosyası']['name']) {
        move_uploaded_file($_FILES['ses_dosyası']['tmp_name'], "audio/$ses_dosyası");
    }

    // Veritabanı güncelleme
    $query = "UPDATE muzikler SET isim = ?, fotoğraf = ?, başlık = ?, ses_dosyası = ? WHERE id = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $isim, $fotoğraf, $başlık, $ses_dosyası, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminMuzik.php");
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
    <title>Düzenle - Müzik Yönetimi</title>
</head>
<body>
    <div class="container">
    <?php include("slidebar.php"); ?>
        <main class="content">
            <center><h2><?php echo $muzik['id'] ? 'Müzik Düzenle' : 'Yeni Müzik Ekle'; ?></h2></center>
            <div class="edit-form-container">
    <form action="düzenle.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $muzik['id']; ?>">
        <input type="text" name="isim" value="<?php echo $muzik['isim']; ?>" placeholder="Müzik İsmi" required><br>
        <input type="file" name="fotoğraf" accept="image/*"><br>
        <input type="text" name="başlık" value="<?php echo $muzik['başlık']; ?>" placeholder="Başlık" required><br>
        <input type="file" name="ses_dosyası" accept="audio/*"><br>
        <button type="submit" name="update_muzik">Güncelle</button>
    </form>
</div>

        </main>
    </div>
</body>
</html>
