<template>
  <div class="card shadow-sm h-100 border-0 rounded-lg overflow-hidden">
    <div class="card-header bg-primary text-white text-center py-3">
      <h3 class="card-title mb-0 fw-bold text-uppercase fs-4">{{ sportName }}</h3>
    </div>

    <div class="card-body p-0">
      <div class="p-3">
        <p class="card-text text-muted mb-2 text-center">
          <span class="fw-semibold">{{ athleteName }}</span> {{ trophyName }}
        </p>
      </div>
      <div class="position-relative overflow-hidden" style="height: 250px;">
        <img :src="athletePhotoUrl" :alt="athleteName" class="w-100 h-100 object-fit-cover">
        <div class="position-absolute bottom-0 w-100 h-50" style="background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0));"></div>
      </div>
    </div>

    <div class="card-footer bg-light d-flex justify-content-around align-items-center py-2">
      <div class="text-center">
        <i class="bi bi-heart-fill text-danger me-1"></i>
        <span class="fw-semibold">{{ likes }}</span>
      </div>
      <div class="text-center">
        <i class="bi bi-chat-dots-fill text-secondary me-1"></i>
        <span class="fw-semibold">{{ comments }}</span>
      </div>
      <div class="text-center">
        <i class="bi bi-share-fill text-info me-1"></i>
        <span class="fw-semibold">{{ shares }}</span>
      </div>
    </div>

    <div class="d-flex border-top">
      <button @click="handleLike" class="btn btn-link flex-fill text-decoration-none text-primary py-3 px-0 border-end">
        <i class="bi bi-hand-thumbs-up fs-5"></i> <span class="d-none d-sm-inline ms-1">Like</span>
      </button>
      <button @click="handleComment" class="btn btn-link flex-fill text-decoration-none text-secondary py-3 px-0 border-end">
        <i class="bi bi-chat fs-5"></i> <span class="d-none d-sm-inline ms-1">Comment</span>
      </button>
      <button @click="handleShare" class="btn btn-link flex-fill text-decoration-none text-info py-3 px-0">
        <i class="bi bi-share fs-5"></i> <span class="d-none d-sm-inline ms-1">Share</span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

// Definojmë props-at që ky komponent do të pranojë
const props = defineProps({
  sportName: {
    type: String,
    required: true
  },
  athleteName: {
    type: String,
    required: true
  },
  trophyName: {
    type: String,
    required: true
  },
  athletePhotoUrl: {
    type: String,
    required: true
  },
  likes: {
    type: Number,
    default: 0
  },
  comments: {
    type: Number,
    default: 0
  },
  shares: {
    type: Number,
    default: 0
  }
});

// Funksionet placeholder për ndërveprimet
const handleLike = () => {
  alert(`Pëlqeve sportin: ${props.sportName}!`);
  // Logjika reale për të rritur numrin e pëlqimeve dhe ruajtur në DB
};

const handleComment = () => {
  alert(`Po komenton për sportin: ${props.sportName}!`);
  // Logjika reale për të hapur një modal komentesh
};

const handleShare = () => {
  alert(`Po shpërndan sportin: ${props.sportName}!`);
  // Logjika reale për ndarjen në rrjete sociale
};
</script>

<style scoped>
/* Asnjë stil shtesë nuk është i nevojshëm, Bootstrap mbulon shumicën */
/* Objekt-fit-cover siguron që imazhi të mbulojë zonën pa shtrembëruar */
.object-fit-cover {
  object-fit: cover;
}

/* Rregullim për butona linku që të mos kenë nënvijëzim në hover nëse nuk duam */
.btn-link:hover {
    text-decoration: none !important;
}

/* Këtu mund të shtohen stile specifike për pamjen e kartës nëse dëshironi */
/* p.sh., për të rregulluar madhësinë e fontit, hapësirat etj. */
</style>