const API_KEY = ''; // Replace with your actual YouTube API key
const randomSongsContainer = document.getElementById('random-songs-list');
const searchResultsContainer = document.getElementById('search-results-list');
const searchResultsSection = document.getElementById('search-results-section');
const searchInput = document.getElementById('song-search-input');
const searchBtn = document.getElementById('song-search-btn');
const playerContainer = document.getElementById('player-container'); // For embedding YouTube video player

// Fetch random songs (popular music videos)
async function fetchRandomSongs() {
  try {
    const response = await fetch(
      `https://www.googleapis.com/youtube/v3/search?part=snippet&chart=mostPopular&type=video&videoCategoryId=10&maxResults=5&key=${API_KEY}`
    );
    const data = await response.json();
    displaySongs(data.items, randomSongsContainer);
  } catch (error) {
    console.error('Error fetching random songs:', error);
    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
  }
}

// Search for songs based on user input
async function searchSongs(query) {
  try {
    const response = await fetch(
      `https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&q=${encodeURIComponent(
        query
      )}&maxResults=5&key=${API_KEY}`
    );
    const data = await response.json();
    displaySongs(data.items, searchResultsContainer);
    searchResultsSection.style.display = 'block';
  } catch (error) {
    console.error('Error searching songs:', error);
    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
  }
}

// Display songs in a container
function displaySongs(songs, container) {
  container.innerHTML = ''; // Clear previous content
  songs.forEach((song) => {
    const videoId = song.id.videoId;
    const title = song.snippet.title;
    const thumbnail = song.snippet.thumbnails.medium.url;

    const songDiv = document.createElement('div');
    songDiv.classList.add('song-item');
    songDiv.innerHTML = `
      <img src="${thumbnail}" alt="${title}">
      <h3>${title}</h3>
      <button onclick="playSong('${videoId}')"><i class="bi bi-play-circle"></i> Dinle</button>
    `;
    container.appendChild(songDiv);
  });
}

// Play the selected song in the embedded YouTube player
function playSong(videoId) {
  playerContainer.innerHTML = ''; // Clear the current player (if any)

  const iframe = document.createElement('iframe');
  iframe.width = '560';
  iframe.height = '315';
  iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
  iframe.frameBorder = '0';
  iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
  iframe.allowFullscreen = true;

  playerContainer.appendChild(iframe);
}

// Event listeners
searchBtn.addEventListener('click', () => {
  const query = searchInput.value.trim();
  if (query) {
    searchSongs(query);
  }
});

// Allow Enter key to trigger search
searchInput.addEventListener('keydown', (event) => {
  if (event.key === 'Enter') {
    const query = searchInput.value.trim();
    if (query) {
      searchSongs(query);
    }
  }
});

// Fetch random songs on page load
fetchRandomSongs();
