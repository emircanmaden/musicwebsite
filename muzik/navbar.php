<aside class="sidebar">
      <div class="logo">
        <a href="index.php">
        <?php if (!empty($logo_file)): ?>
        <img src="logos/<?php echo htmlspecialchars($logo_file); ?>">
    <?php else: ?>
        <p>Logo bulunamadı.</p>
    <?php endif; ?>  
          </a>
      </div>
      <nav>
        <ul>
          <li><a href="index.php"><i class="bi bi-house-door-fill"></i> Ana Sayfa</a></li>
          <li><a href="kesfet.php"><i class="bi bi-compass-fill"></i> Keşfet</a></li>
          <li><a href="trendler.php"><i class="bi bi-bar-chart-line"></i> Trendler</a></li>
          <li><a href="dashboard.php"><i class="bi bi-grid-fill"></i> Admin Panel</a></li> <!-- Grid ikonu -->
          </ul>
      </nav>
      <?php
session_start();
?>

<a href="<?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE ? 'logout.php' : 'login.php'; ?>">
  <button class="login-btn">
    <?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE ? 'Çıkış Yap' : 'Oturum Aç'; ?>
  </button>
</a>

    </aside>