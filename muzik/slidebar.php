<aside class="sidebar">
<div class="logo">
        <a href="dashboard.php">
        <?php if (!empty($logo_file)): ?>
        <img src="logos/<?php echo htmlspecialchars($logo_file); ?>">
    <?php else: ?>
        <p>Logo bulunamadı.</p>
    <?php endif; ?>  
          </a>
      </div>
      <nav>
        <ul>
<li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li> <!-- Dashboard ikonu -->
<li><a href="adminMuzik.php"><i class="fas fa-music"></i> Müzik Yönetimi</a></li> <!-- Müzik ikonu -->
<li><a href="adminLogo.php"><i class="fas fa-image"></i> Logo Yönetimi</a></li> <!-- Logo ikonu -->
<li><a href="adminKesfet.php"><i class="fas fa-compass"></i> Keşfet Yönetimi</a></li> <!-- Keşfet/Compass ikonu -->
<li><a href="index.php"><i class="fas fa-home"></i> Anasayfa</a></li> <!-- Anasayfa/ev ikonu -->

        </ul>
      </nav>
    </aside>