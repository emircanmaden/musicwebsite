document.addEventListener("DOMContentLoaded", () => {
  // Arama işlemleri için değişkenleri tanımla
  const searchInput = document.getElementById("searchInput");
  const songs = document.querySelectorAll(".song");
  const noResultsMessage = document.getElementById("noResultsMessage");

  if (searchInput) {
    searchInput.addEventListener("input", () => {
      const query = searchInput.value.toLowerCase();
      let hasResults = false;

      songs.forEach((song) => {
        const songName = song.dataset.name.toLowerCase();
        const isMatch = songName.includes(query);
        song.style.display = isMatch ? "block" : "none";
        hasResults = hasResults || isMatch;
      });

      // Sonuç yoksa mesaj göster
      if (noResultsMessage) {
        noResultsMessage.style.display = hasResults ? "none" : "block";
      }
    });
  }

  // Ses fonksiyonları
  const playSong = (songName) => {
    // Önceki çalan şarkıyı durdur
    const currentlyPlaying = document.querySelector("audio.playing");
    if (currentlyPlaying) {
      currentlyPlaying.pause();
      currentlyPlaying.classList.remove("playing");
      document.getElementById(`playPause-${currentlyPlaying.id}`).innerHTML = '<i class="bi bi-play-circle"></i>';
    }

    // Yeni şarkıyı oynat
    const audio = document.getElementById(`audio-${songName}`);
    if (audio) {
      audio.play();
      audio.classList.add("playing");
      document.getElementById(`playPause-${songName}`).innerHTML = '<i class="bi bi-pause-circle"></i>';
    }
  };

  const togglePlayPause = (songName) => {
    const audio = document.getElementById(`audio-${songName}`);
    const playPauseBtn = document.getElementById(`playPause-${songName}`);

    if (audio) {
      if (audio.paused) {
        audio.play();
        playPauseBtn.innerHTML = '<i class="bi bi-pause-circle"></i>';
      } else {
        audio.pause();
        playPauseBtn.innerHTML = '<i class="bi bi-play-circle"></i>';
      }
    }
  };

  const changeVolume = (songName) => {
    const audio = document.getElementById(`audio-${songName}`);
    const volumeControl = document.getElementById(`volume-${songName}`);

    if (audio && volumeControl) {
      audio.volume = volumeControl.value;
    }
  };

  const forwardSong = (songName, seconds) => {
    const audio = document.getElementById(`audio-${songName}`);
    if (audio) {
      audio.currentTime += seconds;
    }
  };

  const rewindSong = (songName, seconds) => {
    const audio = document.getElementById(`audio-${songName}`);
    if (audio) {
      audio.currentTime = Math.max(0, audio.currentTime - seconds);
    }
  };

  // Fonksiyonları global erişim için window'a ata
  window.playSong = playSong;
  window.togglePlayPause = togglePlayPause;
  window.changeVolume = changeVolume;
  window.forwardSong = forwardSong;
  window.rewindSong = rewindSong;
});

// Tam ekran fonksiyonları
const makeFullscreen = (element) => {
  if (element.requestFullscreen) {
    element.requestFullscreen();
  } else if (element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if (element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if (element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }

  // Küçültme butonunu göster
  const exitButton = element.querySelector('.exit-fullscreen-btn');
  if (exitButton) {
    exitButton.style.display = 'inline-block';
  }
};

const exitFullscreen = () => {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }

  // Küçültme butonlarını gizle
  document.querySelectorAll('.exit-fullscreen-btn').forEach((button) => {
    button.style.display = 'none';
  });
};

document.addEventListener("DOMContentLoaded", () => {
  const updateProgressBar = (audio, progressBar) => {
    const progress = (audio.currentTime / audio.duration) * 100 || 0;
    progressBar.style.width = `${progress}%`;
  };

  const formatTime = (seconds) => {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes}:${secs < 10 ? "0" : ""}${secs}`;
  };

  const attachAudioControls = (songName) => {
    const audio = document.getElementById(`audio-${songName}`);
    const progressBar = document.querySelector(`#progress-${songName} span`);
    const timeDisplay = document.getElementById(`time-${songName}`);

    if (audio && progressBar && timeDisplay) {
      audio.addEventListener("timeupdate", () => {
        updateProgressBar(audio, progressBar);
        timeDisplay.textContent = `${formatTime(audio.currentTime)} / ${formatTime(audio.duration)}`;
      });

      audio.addEventListener("ended", () => {
        document.getElementById(`playPause-${songName}`).innerHTML = '<i class="bi bi-play-circle"></i>';
      });
    }
  };

  // Mevcut şarkılar için kontrolleri ata
  document.querySelectorAll(".song").forEach((song) => {
    const songName = song.dataset.name;
    attachAudioControls(songName);
  });
});


// Fonksiyonları global erişim için window'a ata
window.makeFullscreen = makeFullscreen;
window.exitFullscreen = exitFullscreen;
