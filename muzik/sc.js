const apiKey = ''; // API anahtarını buraya ekleyin.

// YouTube API ile şarkı arama fonksiyonu
function searchMusic(query) {
  const url = `https://www.googleapis.com/youtube/v3/search?part=snippet&q=${query}&type=video&videoCategoryId=10&key=${apiKey}`;

  fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error('API isteği başarısız oldu. Yanıt:', response.status);
      }
      return response.json();
    })
    .then(data => {
      displaySongs(data.items);
    })
    .catch(error => {
      console.error('API Hatası:', error);
      alert("API hatası! Lütfen daha sonra tekrar deneyin.");
    });
}

// Kategoriye göre şarkıları filtreleme fonksiyonu
function filterCategory(category) {
  const url = `https://www.googleapis.com/youtube/v3/search?part=snippet&q=${category}&type=video&videoCategoryId=10&key=${apiKey}`;

  fetch(url)
    .then(response => {
      if (!response.ok) {
        throw new Error('API isteği başarısız oldu. Yanıt:', response.status);
      }
      return response.json();
    })
    .then(data => {
      displaySongs(data.items);
    })
    .catch(error => {
      console.error('API Hatası:', error);
      alert("API hatası! Lütfen daha sonra tekrar deneyin.");
    });
}

// Şarkıları ekrana listeleme fonksiyonu
function displaySongs(songs) {
  const songsContainer = document.getElementById('songsContainer');
  songsContainer.innerHTML = ''; // Eski şarkıları temizle

  if (songs.length === 0) {
    document.getElementById('noResultsMessage').style.display = 'block';
    return;
  }

  songs.forEach(song => {
    const songElement = document.createElement('div');
    songElement.classList.add('song');
    songElement.dataset.name = song.snippet.title;

    songElement.innerHTML = `
      <img src="${song.snippet.thumbnails.medium.url}" alt="${song.snippet.title}">
      <p>${song.snippet.title}</p>
      <button onclick="playVideo('${song.id.videoId}')">Oynat</button>
    `;

    songsContainer.appendChild(songElement);
  });
}

// YouTube videosunu oynatma fonksiyonu
function playVideo(videoId) {
  const videoUrl = `https://www.youtube.com/watch?v=${videoId}`;
  window.open(videoUrl, '_blank');  // Yeni sekmede video açılır
}
