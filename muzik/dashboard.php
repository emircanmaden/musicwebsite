<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  echo "<script>" . "window.location.href='login.php';" . "</script>";
  exit;
}

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
  <title>Dashboard</title>
  <link rel="stylesheet" href="stilAdmin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    
  <?php include("slidebar.php"); ?>

    <main class="content">
      <h1>Dashboard</h1>
      <p>Hoş geldiniz, yönetim panelinizdeki menüleri kullanabilirsiniz.</p>
    </main>
  </div>
</body>
</html>



