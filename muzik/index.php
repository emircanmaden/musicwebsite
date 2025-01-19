<?php
// Veritabanı bağlantısı
require_once "config.php";
# Logos tablosundan logo dosyasını çek
$logo_query = "SELECT logo_file FROM logos LIMIT 1";
$logo_result = mysqli_query($link, $logo_query);
$logo_data = mysqli_fetch_assoc($logo_result);
$logo_file = $logo_data['logo_file'];
?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Müzik</title>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" href="logo.png">
  <link rel="stylesheet" href="styles.css">
  <script defer src="sc.js"></script>

</head>

<body>
  <div class="container">
    <!-- Sol Menü -->
    <?php include("navbar.php"); ?>

    <!-- İçerik -->
    <main class="content">
      <header class="top-bar">
        <div class="search-bar">
          <i class="bi bi-search"></i>
          <input id="searchInput" type="text" placeholder="Şarkı, albüm veya sanatçı ara" oninput="searchMusic(this.value)">
        </div>
      </header>

      <section class="categories">
        <h2>Öne Çıkanlar</h2>
        <div class="categories-grid">
          <div class="category" onclick="filterCategory('pop')">Pop</div>
          <div class="category" onclick="filterCategory('rock')">Rock</div>
          <div class="category" onclick="filterCategory('jazz')">Jazz</div>
          <div class="category" onclick="filterCategory('klasik')">Klasik</div>
        </div>
      </section>

      <section class="quick-picks">
        <h2>Şarkılar</h2>
        <div id="songsContainer" class="songs">
          <!-- Şarkılar burada görünecek -->
        </div>
        <p id="noResultsMessage" style="display: none; color: gray;">Arama sonucu bulunamadı.</p>
      </section>

    </main>
  </div>
</body>

</html>
