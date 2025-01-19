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

# Logo ekleme ve düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_logo'])) {
    $logo_file = $_FILES['logo_file']['name'];

    # Dosya türünü kontrol et (örneğin .png, .jpg vb.)
    $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
    $logo_type = $_FILES['logo_file']['type'];
    if (!in_array($logo_type, $allowed_image_types)) {
        die("Geçersiz dosya türü.");
    }

    # Dosya yükleme işlemi
    $logo_file = uniqid('logo_') . '.' . pathinfo($logo_file, PATHINFO_EXTENSION);

    $upload_path = "logos/" . $logo_file;
    if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $upload_path)) {
        # Eski logoyu sil (eğer varsa)
        $query = "SELECT logo_file FROM logos LIMIT 1";
        $result = mysqli_query($link, $query);
        $logo = mysqli_fetch_assoc($result);
        if ($logo) {
            unlink("logos/" . $logo['logo_file']);  // Eski logoyu sil
        }

        # Yeni logo dosyasını veritabanına kaydet
        $query = "REPLACE INTO logos (id, logo_file) VALUES (1, ?)";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "s", $logo_file);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: adminLogo.php"); // İşlem tamamlandıktan sonra yönlendirme
            exit;
        } else {
            echo "Hata: " . mysqli_error($link);
        }
    } else {
        echo "Dosya yüklenirken bir hata oluştu.";
    }
}

# Mevcut logo'yu çek
$query = "SELECT * FROM logos LIMIT 1";
$result = mysqli_query($link, $query);
$logo = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logo Yönetimi</title>
    <link rel="stylesheet" href="stilAdmin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include("slidebar.php"); ?>
        <main class="content">
            <center><h1>Logo Yönetimi</h1></center>

            <?php if ($logo): ?>
                <!-- Logo Görüntüle -->
                <div class="logo-container">
                    <center><img src="logos/<?php echo htmlspecialchars($logo['logo_file']); ?>" alt="Logo" width="200"></center>
                </div>
                <hr>

                <!-- Logo Düzenleme Formu -->
                <div class="form-container">
                    <form action="adminLogo.php" method="POST" enctype="multipart/form-data">
                        <label for="logo_file">Yeni Logo Resmi Seçin:</label><br>
                        <input type="file" name="logo_file" accept="image/*" required><br><br>
                        <button type="submit" name="update_logo">Logo Güncelle</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Henüz bir logo yüklenmedi. Lütfen logo yükleyin.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
