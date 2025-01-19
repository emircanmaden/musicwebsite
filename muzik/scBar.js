// Progres bar için güncelleme ve kullanıcı etkileşimlerini sağlayan kodlar
const updateProgressBar = (audio, progressBar) => {
    const progress = (audio.currentTime / audio.duration) * 100 || 0;
    progressBar.style.width = `${progress}%`;
  };
  
  const setAudioProgress = (audio, progressBar, event) => {
    const barWidth = progressBar.offsetWidth;
    const offsetX = event.offsetX;
    const duration = audio.duration;
  
    audio.currentTime = (offsetX / barWidth) * duration;
  };
  
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".song").forEach((song) => {
      const songName = song.dataset.name;
      const audio = document.getElementById(`audio-${songName}`);
      const progressBarContainer = document.getElementById(`progress-${songName}`);
      const progressBarFill = document.querySelector(`#progress-${songName} .progress-fill`);
  
      if (audio && progressBarContainer && progressBarFill) {
        // Şarkı çalarken progres barı güncelle
        audio.addEventListener("timeupdate", () => {
          updateProgressBar(audio, progressBarFill);
        });
  
        // Progres bar tıklamasıyla çalma konumunu değiştir
        progressBarContainer.addEventListener("click", (event) => {
          setAudioProgress(audio, progressBarContainer, event);
        });
  
        // Şarkı sona erdiğinde progres barı sıfırla
        audio.addEventListener("ended", () => {
          progressBarFill.style.width = "0%";
          document.getElementById(`playPause-${songName}`).innerHTML = '<i class="bi bi-play-circle"></i>';
        });
      }
    });
  });
  