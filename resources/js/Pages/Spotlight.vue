<template>
  <div class="spotlight-page mt-5">
    <div class="featured-spotlight bg-dark text-white text-center py-5">
      <div class="container">
        <h1 class="display-5 fw-bold mb-4 text-primary">{{ featuredMoment.title }}</h1>
        <div class="video-container mb-4 mx-auto shadow-lg rounded" style="max-width: 800px; height: 450px;">
          <img v-if="featuredMoment.type === 'image'" :src="featuredMoment.url" :alt="featuredMoment.title" class="w-100 h-100 object-fit-cover rounded">
          <video v-else-if="featuredMoment.type === 'video'" :src="featuredMoment.url" controls class="w-100 h-100 object-fit-cover rounded"></video>
          <div v-else class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white rounded">
            Video/Imazh i Pazgjedhur
          </div>
        </div>
        <p class="lead mb-4">{{ featuredMoment.description }}</p>
        <button class="btn btn-lg btn-outline-light"><i class="bi bi-play-circle me-2"></i> Shikoni Videon</button>
      </div>
    </div>

    <div class="container my-5">
      <h2 class="text-center mb-5 fw-bold text-primary">Momente të Tjera të Theksuara</h2>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <div class="col" v-for="reel in shortReels" :key="reel.id">
          <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden reel-card">
            <div class="reel-thumbnail-container">
              <img :src="reel.thumbnailUrl" class="card-img-top object-fit-cover" :alt="reel.title">
              <div class="play-overlay d-flex align-items-center justify-content-center">
                <i class="bi bi-play-circle-fill text-white fs-1"></i>
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title fw-bold text-truncate">{{ reel.title }}</h5>
              <p class="card-text text-muted small">{{ reel.subtitle }}</p>
            </div>
            <div class="card-footer bg-light border-0 d-flex justify-content-between align-items-center">
              <span class="text-muted small"><i class="bi bi-eye-fill me-1"></i> {{ reel.views }}</span>
              <button class="btn btn-sm btn-link text-primary text-decoration-none"><i class="bi bi-share-fill"></i> Share</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Të dhëna statike për momentin kryesor (Featured Spotlight)
const featuredMoment = ref({
  title: 'Magjia e Messit në Kupën e Botës!',
  description: 'Rikujto momentet më të paharrueshme nga performanca historike e Lionel Messit që i dha Argjentinës Kupën e Botës 2022.',
  url: 'https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-576p.mp4', // Shembull URL video (mund ta ndryshoni)
  // url: 'https://cdn.britannica.com/39/234439-050-6B0C6E96/Lionel-Messi-Argentina-2022-World-Cup-final-match.jpg', // Ose URL imazhi
  type: 'video' // ose 'image'
});

// Të dhëna statike për "reels" (momente të shkurtra)
const shortReels = ref([
  {
    id: 1,
    title: 'Goli i Mbappé ndaj Argjentinës',
    subtitle: 'Ky gol vulosi rikthimin epik të Francës.',
    thumbnailUrl: 'https://icdn.football-espana.net/wp-content/uploads/2023/12/kylian-mbappe-france-argentina-world-cup-final.jpg',
    videoUrl: 'URL_VIDEO_MBAPPE.mp4',
    views: '1.2M'
  },
  {
    id: 2,
    title: 'Performanca e Jokic në Finale',
    subtitle: 'Statistikat mbresëlënëse të Jokic nga finalet e NBA.',
    thumbnailUrl: 'https://cdn.vox-cdn.com/thumbor/P-28W_gO90VqC1kGk7W32-e0_tU=/0x0:4781x3187/1200x800/filters:focal(2009x1210:2773x1974)/cdn.vox-cdn.com/uploads/chorus_image/image/72381283/1498114002.0.jpg',
    videoUrl: 'URL_VIDEO_JOKIC.mp4',
    views: '850K'
  },
  {
    id: 3,
    title: 'Rekordi i Riyad Mahrez',
    subtitle: 'Mahrez thyen rekordin e golave në këtë sezon.',
    thumbnailUrl: 'https://images2.minutemediacdn.com/image/upload/c_crop,w_3607,h_2029,x_0,y_0/c_fill,w_720,ar_16:9,f_auto,q_auto,g_auto/images/GettyImages/mmsport/1256086/01h2c7j04m2p4y4z9m0b.jpg',
    videoUrl: 'URL_VIDEO_MAHREZ.mp4',
    views: '560K'
  },
  {
    id: 4,
    title: 'Fitimi i Wimbledon nga Alcaraz',
    subtitle: 'Momenti historik i Carlos Alcaraz në Wimbledon.',
    thumbnailUrl: 'https://images.tennis.com/image/upload/f_auto,q_auto/a_auto,c_fill,g_face,h_675,w_1200/wimbledon-carlos-alcaraz-novak-djokovic-final-getty-e1d2ac8d-4f18-4c4f-bb2a-b7e192751f7e.jpg',
    videoUrl: 'URL_VIDEO_ALCARAZ.mp4',
    views: '990K'
  }
]);
</script>

<style scoped>
.spotlight-page {
  background-color: #f8f9fa; /* Ngjyrë e lehtë sfondi për të theksuar kartat */
}

/* Stilet për Seksionin Kryesor (Featured Spotlight) */
.featured-spotlight {
  background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), #343a40; /* Overlay mbi një sfond të errët */
  padding: 5rem 0;
}

.video-container {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* Raporti 16:9 për video-t */
  height: 0;
  overflow: hidden;
}

.video-container img,
.video-container video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

/* Stilet për Kartat e Momenteve të Shkurtra (Reels-Style) */
.reel-card {
  position: relative;
  cursor: pointer;
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.reel-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.reel-thumbnail-container {
  position: relative;
  width: 100%;
  padding-bottom: 75%; /* Raporti 4:3 për thumbnail-at, ose 100% për katror */
  overflow: hidden;
}

.reel-thumbnail-container img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.play-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4); /* Overlay i errët gjysmë-transparant */
  opacity: 0; /* Fshehur fillimisht */
  transition: opacity 0.3s ease;
}

.reel-card:hover .play-overlay {
  opacity: 1; /* Shfaqet në hover */
}

.play-overlay i {
  /* Ikonë e madhe play */
  font-size: 4rem; /* Rritja e madhësisë së ikonës */
}

.object-fit-cover {
  object-fit: cover;
}
</style>