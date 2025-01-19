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
  <link rel="stylesheet" href="stilTrend.css">
  <script defer src="scriptTrend.js"></script>
</head>

<body>
  <div class="container">
    <?php include("navbar.php"); ?>

    <main class="content">
      <header class="top-bar">
        <h1>Music Player</h1>
        <div class="search-bar">
          <input type="text" id="song-search-input" placeholder="Şarkı Ara...">
          <button id="song-search-btn"><i class="bi bi-search"></i> Ara</button>
        </div>
      </header>

      <section id="search-results-section">
        <h2>Arama Sonuçları</h2>
        <div id="search-results-list" class="song-list"></div>
      </section>

      <section id="random-songs-section">
        <h2>Trend Şarkılar</h2>
        <div id="random-songs-list" class="song-list"></div>
      </section>

      <!-- YouTube Player için yer -->
      <section id="player-section">
        <h2>Şarkıyı Dinle</h2>
        <div id="player-container"></div>
      </section>
    </main>
  </div>
</body>

</html>
