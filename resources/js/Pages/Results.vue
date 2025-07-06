<template>
  <div class="results-page container my-5">
    <h1 class="text-center mb-4 text-primary fw-bold">Rezultatet e Sporteve</h1>

    <div class="filters-section bg-light p-4 rounded shadow-sm mb-5">
      <h4 class="mb-3 text-secondary">Filtro Rezultatet</h4>
      <div class="row g-3">
        <div class="col-md-4">
          <label for="sportSelect" class="form-label">Sporti:</label>
          <select id="sportSelect" class="form-select" v-model="selectedSport">
            <option value="all">Të Gjitha Sportet</option>
            <option v-for="sport in availableSports" :key="sport" :value="sport">{{ sport }}</option>
          </select>
        </div>

        <div class="col-md-4">
          <label for="dateInput" class="form-label">Data:</label>
          <input type="date" id="dateInput" class="form-control" v-model="selectedDate">
        </div>

        <div class="col-md-4" v-if="selectedSport !== 'all'">
          <label for="leagueSelect" class="form-label">Liga/Turneu:</label>
          <select id="leagueSelect" class="form-select" v-model="selectedLeague">
            <option value="all">Të Gjitha Ligat</option>
            <option v-for="league in availableLeagues" :key="league" :value="league">{{ league }}</option>
          </select>
        </div>
      </div>
    </div>

    <div class="results-display">
      <h3 class="mb-4 text-secondary">Ndeshjet e sotme (ose të filtruara)</h3>
      
      <div v-if="filteredResults.length === 0" class="alert alert-info text-center" role="alert">
        Nuk u gjetën rezultate për kriteret e zgjedhura.
      </div>

      <div v-else class="list-group">
        <div v-for="result in filteredResults" :key="result.id" class="list-group-item list-group-item-action mb-3 rounded shadow-sm">
          <div class="d-flex w-100 justify-content-between align-items-center">
            <div>
              <h5 class="mb-1 fw-bold">{{ result.sport }} - {{ result.league }}</h5>
              <small class="text-muted">{{ formatDate(result.date) }} at {{ result.time }}</small>
            </div>
            <span :class="['badge', getStatusBadge(result.status)]">{{ result.status }}</span>
          </div>

          <div class="d-flex align-items-center justify-content-between mt-2 flex-wrap">
            <div class="team-info text-center flex-grow-1 mx-2">
              <img :src="result.team1Logo" alt="Team 1 Logo" class="team-logo mb-1">
              <p class="mb-0 fw-semibold">{{ result.team1Name }}</p>
            </div>

            <div class="score-info text-center flex-shrink-0 mx-2">
              <h3 class="fw-bold mb-0 text-primary">{{ result.score1 }} - {{ result.score2 }}</h3>
            </div>

            <div class="team-info text-center flex-grow-1 mx-2">
              <img :src="result.team2Logo" alt="Team 2 Logo" class="team-logo mb-1">
              <p class="mb-0 fw-semibold">{{ result.team2Name }}</p>
            </div>
          </div>
          
          <div class="interaction-section border-top mt-3 pt-3 d-flex justify-content-around align-items-center">
            <div class="text-center">
              <i class="bi bi-heart-fill text-danger me-1"></i>
              <span class="fw-semibold">{{ result.likes }}</span>
            </div>
            <div class="text-center">
              <i class="bi bi-chat-dots-fill text-secondary me-1"></i>
              <span class="fw-semibold">{{ result.comments }}</span>
            </div>
            <div class="text-center">
              <i class="bi bi-share-fill text-info me-1"></i>
              <span class="fw-semibold">{{ result.shares }}</span>
            </div>
          </div>

          <div class="d-flex border-top mt-2">
              <button @click="handleLike(result.id)" class="btn btn-link flex-fill text-decoration-none text-primary py-2 px-0 border-end">
                <i class="bi bi-hand-thumbs-up fs-5"></i> <span class="d-none d-sm-inline ms-1">Pëlqe</span>
              </button>
              <button @click="handleComment(result.id)" class="btn btn-link flex-fill text-decoration-none text-secondary py-2 px-0 border-end">
                <i class="bi bi-chat fs-5"></i> <span class="d-none d-sm-inline ms-1">Koment</span>
              </button>
              <button @click="handleShare(result.id)" class="btn btn-link flex-fill text-decoration-none text-info py-2 px-0">
                <i class="bi bi-share fs-5"></i> <span class="d-none d-sm-inline ms-1">Shpërnda</span>
              </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Të dhënat statike për rezultatet
const allResults = ref([
  {
    id: 1,
    sport: 'Football',
    league: 'Premier League',
    team1Name: 'Manchester United',
    team1Logo: 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7a/Manchester_United_FC_crest.svg/1200px-Manchester_United_FC_crest.svg.png',
    score1: 2,
    team2Name: 'Liverpool FC',
    team2Logo: 'https://upload.wikimedia.org/wikipedia/en/0/0c/Liverpool_FC.svg',
    score2: 1,
    date: '2025-07-06',
    time: '19:00',
    status: 'Përfunduar',
    likes: 125, comments: 42, shares: 18
  },
  {
    id: 2,
    sport: 'Basketball',
    league: 'NBA',
    team1Name: 'Los Angeles Lakers',
    team1Logo: 'https://upload.wikimedia.org/wikipedia/commons/3/3c/Los_Angeles_Lakers_logo.svg',
    score1: 105,
    team2Name: 'Boston Celtics',
    team2Logo: 'https://upload.wikimedia.org/wikipedia/en/8/8f/Boston_Celtics.svg',
    score2: 103,
    date: '2025-07-06',
    time: '21:30',
    status: 'Përfunduar',
    likes: 98, comments: 27, shares: 10
  },
  {
    id: 3,
    sport: 'Tennis',
    league: 'Wimbledon',
    team1Name: 'Novak Djokovic',
    team1Logo: '', // Tenisi nuk ka logo ekipesh, mund të jetë ikonë default
    score1: '3', // Tenisi shënohet me sete
    team2Name: 'Carlos Alcaraz',
    team2Logo: '',
    score2: '2',
    date: '2025-07-07',
    time: '14:00',
    status: 'Në Pritje',
    likes: 50, comments: 12, shares: 5
  },
  {
    id: 4,
    sport: 'Football',
    league: 'La Liga',
    team1Name: 'Real Madrid',
    team1Logo: 'https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg',
    score1: 1,
    team2Name: 'FC Barcelona',
    team2Logo: 'https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg',
    score2: 1,
    date: '2025-07-06',
    time: '17:00',
    status: 'Në Vazhdim',
    likes: 230, comments: 85, shares: 30
  },
  {
    id: 5,
    sport: 'Handball',
    league: 'Champions League',
    team1Name: 'Vardar 1961',
    team1Logo: 'https://upload.wikimedia.org/wikipedia/en/thumb/4/4e/RK_Vardar_1961_logo.png/600px-RK_Vardar_1961_logo.png',
    score1: 28,
    team2Name: 'Barça (Handball)',
    team2Logo: 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/FC_Barcelona_handball_logo.svg/1200px-FC_Barcelona_handball_logo.svg.png',
    score2: 27,
    date: '2025-07-05',
    time: '20:00',
    status: 'Përfunduar',
    likes: 70, comments: 15, shares: 8
  },
  {
    id: 6,
    sport: 'Volleyball',
    league: 'Superliga',
    team1Name: 'KV Peja',
    team1Logo: 'https://via.placeholder.com/50x50?text=KV+P',
    score1: '3', // Volleyball shënohet me sete
    team2Name: 'KV Prishtina',
    team2Logo: 'https://via.placeholder.com/50x50?text=KV+PR',
    score2: '0',
    date: '2025-07-05',
    time: '18:00',
    status: 'Përfunduar',
    likes: 45, comments: 10, shares: 3
  }
]);

// Variablat reaktive për filtra
const selectedSport = ref('all');
const selectedDate = ref(new Date().toISOString().slice(0, 10)); // Data e sotme si fillim
const selectedLeague = ref('all');

// Llogarit sportet unike të disponueshme nga të dhënat
const availableSports = computed(() => {
  const sports = new Set();
  allResults.value.forEach(result => sports.add(result.sport));
  return Array.from(sports);
});

// Llogarit ligat unike të disponueshme bazuar në sportin e zgjedhur
const availableLeagues = computed(() => {
  if (selectedSport.value === 'all') return [];
  const leagues = new Set();
  allResults.value
    .filter(result => result.sport === selectedSport.value)
    .forEach(result => leagues.add(result.league));
  return Array.from(leagues);
});

// Llogarit rezultatet e filtruara
const filteredResults = computed(() => {
  return allResults.value.filter(result => {
    const matchesSport = selectedSport.value === 'all' || result.sport === selectedSport.value;
    const matchesDate = selectedDate.value === '' || result.date === selectedDate.value;
    const matchesLeague = selectedLeague.value === 'all' || result.league === selectedLeague.value;
    return matchesSport && matchesDate && matchesLeague;
  });
});

// Funksion ndihmës për formatimin e datës (opsionale)
const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('sq-AL', options);
};

// Funksion për të marrë klasën e badge-it bazuar në status
const getStatusBadge = (status) => {
  switch (status) {
    case 'Përfunduar': return 'bg-success';
    case 'Në Vazhdim': return 'bg-warning text-dark';
    case 'Në Pritje': return 'bg-info';
    default: return 'bg-secondary';
  }
};

// Funksionet placeholder për ndërveprimet
const handleLike = (resultId) => {
  // Këtu do të dërgohet kërkesa në backend për të regjistruar pëlqimin
  alert(`Pëlqeve rezultatin me ID: ${resultId}!`);
  // Logjika reale: Shto / hiq pëlqimin, azhurno numrin
};

const handleComment = (resultId) => {
  // Këtu do të hapet një modal ose seksion për komente
  alert(`Po komenton për rezultatin me ID: ${resultId}!`);
  // Logjika reale: Hape modalin e komenteve
};

const handleShare = (resultId) => {
  // Këtu do të hapet një dritare për shpërndarje në rrjete sociale
  alert(`Po shpërndan rezultatin me ID: ${resultId}!`);
  // Logjika reale: Integroj me API-të e shpërndarjes (p.sh., Facebook, Twitter)
};
</script>

<style scoped>
.results-page {
  background-color: #f8f9fa; /* Ngjyrë e lehtë sfondi */
  padding: 2rem;
  border-radius: 8px;
}

.filters-section {
  border-left: 5px solid var(--bs-primary); /* Një detaj vizual */
}

.team-logo {
  width: 50px;
  height: 50px;
  object-fit: contain; /* Përshtatet pa shkallëzim */
}

.list-group-item {
  border: none;
  border-bottom: 1px solid #eee;
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.list-group-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
}

.score-info h3 {
  font-size: 2.5rem; /* Madhësia e rezultatit */
}

.team-info {
  min-width: 120px; /* Siguron hapësirë minimale për emrin e ekipit/lojtarit */
}

.interaction-section {
    color: #6c757d; /* Ngjyra e ikonave dhe numrave */
    font-size: 0.9rem;
}

.interaction-section i {
    font-size: 1.1rem;
}

.btn-link {
    font-size: 0.95rem;
}

/* Rregullim për ekranet e vogla */
@media (max-width: 575.98px) {
  .team-info {
    flex-grow: 0;
    min-width: unset;
  }
  .score-info {
    margin: 0 1rem;
  }
  .list-group-item .d-flex.flex-wrap {
      justify-content: center !important;
  }
}
</style>