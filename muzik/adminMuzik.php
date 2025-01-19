<?php
// Veritabanı bağlantısı
require_once "config.php";
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    echo "<script>" . "window.location.href='login.php';" . "</script>";
    exit;
  }

# Logos tablosundan logo dosyasını çek
$logo_query = "SELECT logo_file FROM logos LIMIT 1";
$logo_result = mysqli_query($link, $logo_query);
$logo_data = mysqli_fetch_assoc($logo_result);
$logo_file = $logo_data['logo_file'];

// Müzikleri al
$query = "SELECT * FROM muzikler";
$result = mysqli_query($link, $query);
$muzikler = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Müzik silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM muzikler WHERE id = $id";
    if (mysqli_query($link, $query)) {
        header("Location: adminMuzik.php"); // Silme işlemi sonrası geri yönlendirme
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
    <title>Müzik Yönetimi</title>
</head>
<body>
    <div class="container">
    <?php include("slidebar.php"); ?>
        <main class="content">
            <center><h2>Mevcut Müzikler</h2></center>
            <center><a href="ekle.php" class="add-button">+ Ekle</a></center>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>İsim</th>
                        <th>Fotoğraf</th>
                        <th>Başlık</th>
                        <th>Ses Dosyası</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($muzikler as $muzik): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($muzik['isim']); ?></td>
                            <td><img src="img/<?php echo htmlspecialchars($muzik['fotoğraf']); ?>" alt="Fotoğraf" width="50"></td>
                            <td><?php echo htmlspecialchars($muzik['başlık']); ?></td>
                            <td><a href="audio/<?php echo htmlspecialchars($muzik['ses_dosyası']); ?>">Dinle</a></td>
                            <td>
                                <a href="düzenle.php?id=<?php echo $muzik['id']; ?>">Düzenle</a> | 
                                <a href="?delete=<?php echo $muzik['id']; ?>">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
