<?php
// Veritabanı bağlantısı
require_once "config.php";

// Müzikleri al
$query = "SELECT * FROM muzikler";
$result = mysqli_query($link, $query);
$muzikler = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Keşfet yazılarını al
$query = "SELECT * FROM keşfet";
$result = mysqli_query($link, $query);
$kesfet_yazilari = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Logo dosyasını al
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
  <title>Ana Sayfa</title>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" href="logo.png">
  <link rel="stylesheet" href="styles.css">
  <script defer src="script.js"></script>
  <script defer src="scBar.js"></script>

</head>
<body>
  <div class="container">
    <!-- Sol Menü -->
    <?php include("navbar.php"); ?>

    <!-- İçerik -->
    <main class="content">
      <header class="top-bar">
        <h1>Müzik</h1>
      </header>

      <section class="hero-section">
        <?php if (!empty($kesfet_yazilari)): ?>
          <?php foreach ($kesfet_yazilari as $yazi): ?>
            <div class="hero-text">
              <h2><?php echo htmlspecialchars($yazi['başlık']); ?></h2>
              <p><?php echo htmlspecialchars($yazi['açıklama']); ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Henüz keşfet yazısı eklenmemiş.</p>
        <?php endif; ?>

        <?php if (!empty($logo_file)): ?>
          <img src="logos/<?php echo htmlspecialchars($logo_file); ?>" alt="Logo">
        <?php else: ?>
          <p>Logo bulunamadı.</p>
        <?php endif; ?>
      </section>

      <section class="songs-container">
        <div id="songsContainer" class="songs">
          <?php foreach ($muzikler as $muzik): ?>
            <div class="song" data-name="<?php echo htmlspecialchars($muzik['isim']); ?>">
              
              <img id="fullscreenImage"
                src="img/<?php echo htmlspecialchars($muzik['fotoğraf']); ?>" 
                alt="<?php echo htmlspecialchars($muzik['isim']); ?>" 
                class="song-image"
              >
              <p class="song-name"><?php echo htmlspecialchars($muzik['isim']); ?></p>
              <audio 
                id="audio-<?php echo htmlspecialchars($muzik['isim']); ?>" 
                src="audio/<?php echo htmlspecialchars($muzik['ses_dosyası']); ?>">
              </audio>

              <div class="controls">
                <!-- Geri Sarma -->
                <button 
                  onclick="rewindSong('<?php echo htmlspecialchars($muzik['isim']); ?>', 10)" 
                  class="control-btn rewind">
                  <i class="bi bi-skip-backward"></i> 
                </button>

                <!-- Oynat/Durdur -->
                <button 
                  id="playPause-<?php echo htmlspecialchars($muzik['isim']); ?>" 
                  class="control-btn play-pause-btn" 
                  onclick="togglePlayPause('<?php echo htmlspecialchars($muzik['isim']); ?>')">
                  <i class="bi bi-play-circle"></i>
                </button>

                <!-- İleri Sarma -->
                <button 
                  onclick="forwardSong('<?php echo htmlspecialchars($muzik['isim']); ?>', 10)" 
                  class="control-btn forward">
                  <i class="bi bi-skip-forward"></i> 
                </button>

                <!-- Tam Ekran -->
                <button 
                  onclick="makeFullscreen(this.parentElement.parentElement)" 
                  class="control-btn fullscreen-btn">
                  <i class="bi bi-arrows-fullscreen"></i>
                </button>
              </div>

              <!-- Ses Seviyesi Kontrolü -->
              <input 
                type="range" 
                id="volume-<?php echo htmlspecialchars($muzik['isim']); ?>" 
                class="volume-control" 
                min="0" 
                max="1" 
                step="0.01" 
                value="1" 
                onchange="changeVolume('<?php echo htmlspecialchars($muzik['isim']); ?>')">


                <!-- İlerleme Çubuğu -->
<div 
  class="progress-bar" 
  id="progress-<?php echo htmlspecialchars($muzik['isim']); ?>" 
  onclick="setProgress('<?php echo htmlspecialchars($muzik['isim']); ?>', event)">
  <div class="progress-fill" id="progressFill-<?php echo htmlspecialchars($muzik['isim']); ?>"></div>
</div>


              <!-- Tam Ekrandan Çıkış -->
              <button 
                onclick="exitFullscreen()" 
                class="control-btn exit-fullscreen-btn" 
                style="display: none;">
                <i class="bi bi-x-circle"></i>
              </button>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
