<template>
  <div class="spotlight-page d-flex mt-5 flex-column align-items-center bg-dark text-white vh-100 overflow-hidden">


    <div class="reels-container flex-grow-1 d-flex flex-column align-items-center justify-content-center w-100">
      <div class="reel-viewer-wrapper position-relative">
        <div class="reel-viewer" ref="reelViewer">
          <div v-for="(video, index) in videos" :key="video.id"
               :id="`video-${video.id}`"
               :class="['reel-item', { 'active': currentVideoIndex === index }]">

            <video
              :src="video.src"
              loop
              muted
              playsinline
              preload="auto"
              ref="videoPlayers"
              @loadedmetadata="onVideoLoaded(index)"
              @ended="playNextVideo"
              class="video-player"
            ></video>

            <div class="video-overlay d-flex flex-column justify-content-end p-3">
              <div class="video-info d-flex flex-column">
                <h5 class="fw-bold mb-1">{{ video.title }}</h5>
                <p class="text-white-50 mb-2">@{{ video.username }}</p>
                <p class="video-description">{{ video.description }}</p>
              </div>

              <div class="video-actions d-flex flex-column align-items-end">
                <button @click="toggleLike(video)" class="btn action-btn mb-3">
                  <i :class="['bi', video.liked ? 'bi-heart-fill text-danger' : 'bi-heart']"></i>
                  <span>{{ video.likes }}</span>
                </button>
                <button @click="openCommentsModal(video)" class="btn action-btn mb-3">
                  <i class="bi bi-chat-fill"></i>
                  <span>{{ video.comments.length }}</span>
                </button>
                <button @click="shareVideo(video)" class="btn action-btn mb-3">
                  <i class="bi bi-share-fill"></i>
                </button>
                <button @click="saveVideo(video)" class="btn action-btn">
                  <i :class="['bi', video.saved ? 'bi-bookmark-fill' : 'bi-bookmark']"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <button v-if="videos.length > 1 && currentVideoIndex > 0" @click="previousVideo" class="nav-arrow prev-arrow d-none d-md-block">
          <i class="bi bi-chevron-up"></i>
        </button>
        <button v-if="videos.length > 1 && currentVideoIndex < videos.length - 1" @click="nextVideo" class="nav-arrow next-arrow d-none d-md-block">
          <i class="bi bi-chevron-down"></i>
        </button>
      </div>
    </div>

    <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="commentsModalLabel">Komente për Videon</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body bg-light">
            <div v-if="selectedVideo && selectedVideo.comments.length > 0">
              <div v-for="(comment, cIndex) in selectedVideo.comments" :key="cIndex" class="comment-item p-2 mb-2 rounded">
                <strong>{{ comment.username }}</strong>: {{ comment.text }}
              </div>
            </div>
            <div v-else class="text-center text-muted">
              Nuk ka komente. Ji i pari që komenton!
            </div>
          </div>
          <div class="modal-footer d-block">
            <form @submit.prevent="addComment">
              <div class="input-group">
                <input type="text" class="form-control" v-model="newCommentText" placeholder="Shto një koment..." required>
                <button type="submit" class="btn btn-primary">Dërgo</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { Modal } from 'bootstrap'; // Importo klasën Modal nga Bootstrap

const videos = ref([
  {
    id: 1,
    src: '/videos/football_goal.mp4', // Sigurohu që këto video ekzistojnë në public/videos
    title: 'Goli Fantastik i Mbappé!',
    username: 'football_fanatic',
    description: 'Një gol i mrekullueshëm nga Kylian Mbappé që i la të gjithë pa fjalë.',
    likes: 1250,
    comments: [{ username: 'User1', text: 'Gol i jashtëzakonshëm!' }, { username: 'SportsLover', text: 'Talent i pastër!' }],
    liked: false,
    saved: false,
  },
  {
    id: 2,
    src: '/videos/basketball_dunk.mp4',
    title: 'Dunk i pabesueshëm nga Giannis!',
    username: 'bball_guru',
    description: 'Giannis Antetokounmpo me një dunk që shpërtheu arenën!',
    likes: 980,
    comments: [{ username: 'HoopsMaster', text: 'Forcë dhe teknikë!' }],
    liked: false,
    saved: false,
  },
  {
    id: 3,
    src: '/videos/tennis_rally.mp4',
    title: 'Rally epike në Wimbledon!',
    username: 'tennis_ace',
    description: 'Shkëmbim topash që zgjati një përjetësi!',
    likes: 720,
    comments: [],
    liked: false,
    saved: false,
  },
  {
    id: 4,
    src: '/videos/f1_overtake.mp4',
    title: 'Kapërcim dramatik në Formula 1!',
    username: 'speed_demon',
    description: 'Max Verstappen me një kapërcim të guximshëm në kthesën e fundit.',
    likes: 1500,
    comments: [{ username: 'RaceFan', text: 'Adrenalinë e pastër!' }, { username: 'F1Insider', text: 'Çfarë manovre!' }],
    liked: false,
    saved: false,
  },
   {
    id: 5,
    src: '/videos/volleyball_spike.mp4',
    title: 'Spike vrasës nga Egonu!',
    username: 'volley_pro',
    description: 'Paola Egonu me një pikë të fuqishme që shkatërroi bllokun kundërshtar!',
    likes: 850,
    comments: [{ username: 'VolleyFan', text: 'Fuqi e pabesueshme!' }],
    liked: false,
    saved: false,
  }
]);

const currentVideoIndex = ref(0);
const videoPlayers = ref([]); // Kjo do të mbajë referencat te elementët <video>
const reelViewer = ref(null); // Referenca te div-i reel-viewer
let commentsModal = null; // Instanca e modalit të komenteve
const selectedVideo = ref(null); // Videoja e zgjedhur për komente
const newCommentText = ref(''); // Teksti i komentit të ri

// Funksioni për të luajtur videon aktuale
const playCurrentVideo = () => {
  nextTick(() => { // Sigurohu që DOM-i të jetë azhurnuar
    videoPlayers.value.forEach((player, index) => {
      if (index === currentVideoIndex.value) {
        player.muted = false; // Bëje audion të dëgjueshme për videon aktive
        player.play().catch(e => console.error("Video play failed:", e));
      } else {
        player.pause();
        player.currentTime = 0; // Ktheje në fillim
        player.muted = true; // Bëje mute videon jo-aktive
      }
    });
  });
};

// Funksioni kur videoja ngarkohet
const onVideoLoaded = (index) => {
  if (index === currentVideoIndex.value) {
    playCurrentVideo();
  } else {
    // Sigurohuni që videot jo-aktive të jenë të heshtura dhe të ndalojnë
    if (videoPlayers.value[index]) {
      videoPlayers.value[index].muted = true;
      videoPlayers.value[index].pause();
      videoPlayers.value[index].currentTime = 0;
    }
  }
};

// Funksioni për të luajtur videon tjetër pas përfundimit të një videoje
const playNextVideo = () => {
  if (currentVideoIndex.value < videos.value.length - 1) {
    currentVideoIndex.value++;
    scrollToCurrentVideo();
    playCurrentVideo();
  } else {
    // Opsionale: Kthehu në videon e parë ose ndalo
    currentVideoIndex.value = 0; // Kthehu në fillim
    scrollToCurrentVideo();
    playCurrentVideo();
  }
};

// Funksionet e navigacionit
const nextVideo = () => {
  if (currentVideoIndex.value < videos.value.length - 1) {
    currentVideoIndex.value++;
    scrollToCurrentVideo();
    playCurrentVideo();
  }
};

const previousVideo = () => {
  if (currentVideoIndex.value > 0) {
    currentVideoIndex.value--;
    scrollToCurrentVideo();
    playCurrentVideo();
  }
};

// Funksion për të scroll-uar te videoja aktuale
const scrollToCurrentVideo = () => {
  if (reelViewer.value && videoPlayers.value[currentVideoIndex.value]) {
    const targetElement = videoPlayers.value[currentVideoIndex.value].parentElement; // Parenti i video playerit është reel-item
    if (targetElement) {
      reelViewer.value.scrollTo({
        top: targetElement.offsetTop,
        behavior: 'smooth'
      });
    }
  }
};

// Funksionalitetet e aksioneve
const toggleLike = (video) => {
  video.liked = !video.liked;
  if (video.liked) {
    video.likes++;
  } else {
    video.likes--;
  }
};

const shareVideo = (video) => {
  alert(`Video "${video.title}" u shpërnda! (Funksionalitet real do të vijë në backend)`);
  // Në një aplikacion real, do të përdorej Web Share API ose një modal ndarjeje.
};

const saveVideo = (video) => {
  video.saved = !video.saved;
  alert(`Video "${video.title}" u ${video.saved ? 'ruajt' : 'çruajt'}!`);
};

// Funksionaliteti i komenteve
const openCommentsModal = (video) => {
  selectedVideo.value = video;
  newCommentText.value = ''; // Pastro fushen e komentit
  commentsModal.show(); // Shfaq modalin
};

const addComment = () => {
  if (newCommentText.value.trim() !== '' && selectedVideo.value) {
    // Këtu duhet të zëvendësohet 'Përdoruesi' me emrin real të përdoruesit të loguar
    selectedVideo.value.comments.push({ username: 'Përdoruesi', text: newCommentText.value.trim() });
    newCommentText.value = '';
    alert('Komenti u shtua!');
    // Në një aplikacion real, do të dërgohej në backend
  }
};

// Logjika për scroll me rrotën e mausit (mouse wheel)
const handleScroll = (event) => {
  event.preventDefault(); // Parandalo scroll-in e faqes
  if (event.deltaY > 0) {
    nextVideo();
  } else {
    previousVideo();
  }
};

onMounted(() => {
  // Inicializo modalin e Bootstrap
  const modalElement = document.getElementById('commentsModal');
  if (modalElement) {
    commentsModal = new Modal(modalElement);
  }

  // Inicializo videon e parë
  if (videos.value.length > 0) {
    playCurrentVideo();
  }

  // Shto event listener për scroll në dritare (ose në reelViewer)
  if (reelViewer.value) {
    reelViewer.value.addEventListener('wheel', handleScroll, { passive: false });
  }
});

onUnmounted(() => {
  // Pastro event listener kur komponenti shkatërrohet
  if (reelViewer.value) {
    reelViewer.value.removeEventListener('wheel', handleScroll);
  }
  // Sigurohu që modal-i të fshihet
  if (commentsModal) {
    commentsModal.dispose();
  }
});
</script>

<style scoped>
.spotlight-page {
  height: calc(100vh - 56px); /* 100vh minus lartësinë e navbar-it */
  position: relative;
  overflow: hidden; /* Fsheh scrollbar-in e përgjithshëm të faqes */
}

h1 {
  z-index: 1000; /* Sigurohuni që titulli të jetë mbi videot */
  position: absolute;
  top: 20px;
}

.reels-container {
  width: 100%;
  height: 100%; /* Përdor lartësinë e mbetur */
  display: flex;
  justify-content: center;
  align-items: center;
}

.reel-viewer-wrapper {
  position: relative;
  width: 100%;
  max-width: 400px; /* Gjerësia maksimale e pamjes së reels */
  height: 100%;
  max-height: 700px; /* Lartësia maksimale e pamjes së reels */
  background-color: #000;
  border-radius: 15px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}

.reel-viewer {
  width: 100%;
  height: 100%;
  position: relative;
  overflow-y: scroll; /* Krijon scroll-in vertikal brenda reels */
  scroll-snap-type: y mandatory; /* Siguron që videot të ndalojnë saktë */
  scroll-behavior: smooth; /* Scroll i butë */
  -ms-overflow-style: none; /* Fsheh scrollbar-in për IE dhe Edge */
  scrollbar-width: none; /* Fsheh scrollbar-in për Firefox */
}

.reel-viewer::-webkit-scrollbar {
  display: none; /* Fsheh scrollbar-in për Chrome, Safari, Opera */
}

.reel-item {
  width: 100%;
  height: 100%;
  scroll-snap-align: start; /* Ngalitet në fillim të secilës video */
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  background-color: black; /* Siguron që sfondi të jetë i zi */
}

.video-player {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Siguron që videoja të mbulojë të gjithë hapësirën */
}

.video-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 40%, rgba(0, 0, 0, 0.3) 100%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end; /* Shtyn përmbajtjen në fund */
  color: white;
  padding: 1rem;
}

.video-info {
  align-self: flex-start; /* Info-t në fund majtas */
  max-width: 70%; /* Lejon hapësirë për butonat e veprimeve */
}

.video-info h5 {
  font-size: 1.25rem;
}

.video-description {
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.8);
}

.video-actions {
  position: absolute; /* Pozicionimi absolut për butonat e veprimeve */
  right: 1rem;
  bottom: 1rem;
  z-index: 10;
}

.action-btn {
  background: none;
  border: none;
  color: white;
  font-size: 1.8rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0;
  line-height: 1;
}

.action-btn i {
  margin-bottom: 5px;
  font-size: 2rem;
}

.action-btn span {
  font-size: 0.8rem;
}

.action-btn:hover {
  color: var(--bs-primary);
  opacity: 0.8;
}

/* Navigacion Arrows */
.nav-arrow {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(0, 0, 0, 0.5);
  border: none;
  border-radius: 50%;
  color: white;
  font-size: 2rem;
  cursor: pointer;
  z-index: 20;
  width: 40px;
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: background-color 0.2s ease;
}

.nav-arrow:hover {
  background-color: rgba(0, 0, 0, 0.7);
}

.prev-arrow {
  top: 10px;
}

.next-arrow {
  bottom: 10px;
}

/* Modal Styling */
.modal-content {
  border-radius: 10px;
}

.comment-item {
  background-color: #e9ecef;
  border-radius: 5px;
}

.comment-item + .comment-item {
  margin-top: 8px;
}

/* Media Queries for Responsiveness */
@media (max-width: 767.98px) {
  .spotlight-page {
    padding-top: 0; /* Hiq padding-un e lartësisë së h1 */
  }

  h1 {
    display: none !important; /* Fsheh titullin h1 në mobile */
  }

  .reel-viewer-wrapper {
    max-width: 100%;
    max-height: 100%;
    border-radius: 0;
  }

  .nav-arrow {
    display: none !important; /* Fsheh shigjetat e navigimit në mobile, përdor scroll */
  }

  .action-btn {
    font-size: 1.5rem;
  }
  .action-btn i {
    font-size: 1.8rem;
  }
}
</style>