<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    echo "<script>" . "window.location.href='login.php';" . "</script>";
    exit;
}

# Veritabanı bağlantısı
require_once "config.php";

# Logos tablosundan logo dosyasını çek
$logo_query = "SELECT logo_file FROM logos LIMIT 1";
$logo_result = mysqli_query($link, $logo_query);
$logo_data = mysqli_fetch_assoc($logo_result);
$logo_file = $logo_data['logo_file'];

# Başlık ve açıklama ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_text'])) {
    $başlık = mysqli_real_escape_string($link, $_POST['başlık']);
    $açıklama = mysqli_real_escape_string($link, $_POST['açıklama']);

    # Veritabanına ekleme
    $query = "INSERT INTO keşfet (başlık, açıklama) VALUES (?, ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "ss", $başlık, $açıklama);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminKesfet.php"); // Yönlendirme
        exit;
    } else {
        echo "Hata: " . mysqli_error($link);
    }
}

# Silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM keşfet WHERE id = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminKesfet.php"); // Silme işleminden sonra sayfayı yenileyin
        exit;
    } else {
        echo "Hata: " . mysqli_error($link);
    }
}

# Mevcut başlık ve açıklamaları çek
$query = "SELECT * FROM keşfet";
$result = mysqli_query($link, $query);
$keşfetler = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keşfet Yönetimi</title>
    <link rel="stylesheet" href="stilAdmin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include("slidebar.php"); ?>

        <main class="content">
            <center><h1>Keşfet Yönetimi</h1></center>

            <!-- Başlık ve Açıklama Ekleme Formu -->
            <div class="form-container">
                <form action="adminKesfet.php" method="POST">
                    <label for="başlık">Başlık:</label><br>
                    <input type="text" name="başlık" required><br><br>
                    <label for="açıklama">Açıklama:</label><br>
                    <textarea name="açıklama" rows="5" id="açıklama" required></textarea><br><br>
                    <button type="submit" name="add_text">Ekle</button>
                </form>
            </div>
            <hr>

            <!-- Mevcut Başlıklar ve Açıklamalar -->
            <center><h2>Mevcut Keşfet Yazıları</h2></center>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keşfetler as $keşfet): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($keşfet['başlık']); ?></td>
                            <td>
                                <?php 
                                    $açıklama = $keşfet['açıklama'];
                                    $kısa_açıklama = strlen($açıklama) > 100 ? substr($açıklama, 0, 100) . "..." : $açıklama;
                                    echo htmlspecialchars($kısa_açıklama);
                                ?>
                                <?php if (strlen($açıklama) > 100): ?>
                                    <a href="#" onclick="alert('<?php echo addslashes($açıklama); ?>')">Oku</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- Silme Butonu -->
                                <a href="?delete=<?php echo $keşfet['id']; ?>" onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?')">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>

