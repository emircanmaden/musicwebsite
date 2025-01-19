-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 Oca 2025, 00:10:08
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `muzik`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `keşfet`
--

CREATE TABLE `keşfet` (
  `id` int(11) NOT NULL,
  `başlık` varchar(255) NOT NULL,
  `açıklama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `keşfet`
--

INSERT INTO `keşfet` (`id`, `başlık`, `açıklama`) VALUES
(5, 'SQL Müzik Ruhun Gıdasıdır', 'Sevdiğiniz müzikleri keşfedin, dinleyin ve paylaşın!');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `logos`
--

CREATE TABLE `logos` (
  `id` int(11) NOT NULL,
  `logo_file` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `logos`
--

INSERT INTO `logos` (`id`, `logo_file`, `created_at`) VALUES
(1, 'logo_678a1e4e351f7.png', '2025-01-17 09:09:34'),
(4, 'logo_676c4f593978f.jpg', '2024-12-25 18:30:49');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `muzikler`
--

CREATE TABLE `muzikler` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `fotoğraf` varchar(255) NOT NULL,
  `başlık` varchar(255) NOT NULL,
  `ses_dosyası` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `muzikler`
--

INSERT INTO `muzikler` (`id`, `isim`, `fotoğraf`, `başlık`, `ses_dosyası`) VALUES
(3, 'mızrak', 'logo.png', 'mızrak', 'Era7Capone-PIST-10.mp3'),
(4, 'Semicenk', 'Ekran görüntüsü 2024-12-30 122139.png', 'Semicenk', 'Semicenk-Gözlerinden-Gözlerine-_-Prod.-Melih-Kızılboğa-_.mp3');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `reg_date`) VALUES
(10, 'emircanmaden', 'emircanmaden123@gmail.com', '$2y$10$QVL8xcRxH/Md8cT4USnM9OsToKMl5lZhmUOe7BGuCR1E7ZQHHRVRi', '2024-12-19 02:14:27'),
(11, 'muhammed', 'muhammedmemis52@gmail.com', '$2y$10$BJQHkTuW6Jt2410zHRjlduP6shypdiCpKEdNQBuIn9MAMUdwPSp2W', '2024-12-19 15:09:15');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `keşfet`
--
ALTER TABLE `keşfet`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `muzikler`
--
ALTER TABLE `muzikler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `keşfet`
--
ALTER TABLE `keşfet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `logos`
--
ALTER TABLE `logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `muzikler`
--
ALTER TABLE `muzikler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
