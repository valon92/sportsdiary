<template>
    <div class="players-page container my-5">
      <h1 class="text-center mb-5 text-primary fw-bold">Lojtarët Sportivë</h1>
  
      <div class="filters-search-section bg-light p-4 rounded shadow-sm mb-5">
        <h4 class="mb-3 text-secondary">Gjej Lojtarë</h4>
        <div class="row g-3">
          <div class="col-md-4">
            <label for="sportFilter" class="form-label">Filtro sipas Sportit:</label>
            <select id="sportFilter" class="form-select" v-model="selectedSport">
              <option value="all">Të Gjitha Sportet</option>
              <option v-for="sport in availableSports" :key="sport" :value="sport">{{ sport }}</option>
            </select>
          </div>
  
          <div class="col-md-4">
            <label for="positionFilter" class="form-label">Filtro sipas Pozicionit:</label>
            <select id="positionFilter" class="form-select" v-model="selectedPosition">
              <option value="all">Të Gjitha Pozicionet</option>
              <option v-for="position in availablePositions" :key="position" :value="position">{{ position }}</option>
            </select>
          </div>
  
          <div class="col-md-4">
            <label for="playerSearch" class="form-label">Kërko Lojtar:</label>
            <div class="input-group">
              <input type="text" id="playerSearch" class="form-control" placeholder="Kërko sipas emrit të lojtarit..." v-model="searchTerm">
              <button class="btn btn-primary" @click="searchTerm = ''"><i class="bi bi-x-lg"></i></button>
            </div>
          </div>
        </div>
      </div>
  
      <div class="players-list">
        <h3 class="mb-4 text-secondary">Lojtarët e Gjetur</h3>
        <div v-if="filteredPlayers.length === 0" class="alert alert-info text-center" role="alert">
          Nuk u gjetën lojtarë për kriteret e zgjedhura.
        </div>
        <div v-else class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
          <div class="col" v-for="player in filteredPlayers" :key="player.id">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden player-card text-center">
              <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                <img :src="player.imageUrl" :alt="player.name + ' Photo'" class="player-photo mb-3">
                <h5 class="card-title fw-bold mb-1 text-primary">{{ player.name }}</h5>
                <p class="card-text text-muted small mb-1">{{ player.sport }} - {{ player.position }}</p>
                <p class="card-text text-secondary small">{{ player.team }}</p>
              </div>
              <div class="card-footer bg-light border-0">
                  <button @click="viewPlayerDetails(player.id)" class="btn btn-outline-primary btn-sm w-100">Shiko Statistiket</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Të dhënat statike për lojtarët
  const allPlayers = ref([
    {
      id: 1,
      name: 'Lionel Messi',
      sport: 'Football',
      position: 'Sulmues',
      team: 'Inter Miami CF',
      imageUrl: 'https://img.olympicchannel.com/images/image/private/t_1-1_760/f_auto/v1538355600/primary/wovt8qgshc8j9vsv9n8u'
    },
    {
      id: 2,
      name: 'Cristiano Ronaldo',
      sport: 'Football',
      position: 'Sulmues',
      team: 'Al Nassr FC',
      imageUrl: 'https://b.fssta.com/uploads/application/soccer/headshots/748.vresize.350.350.latest.png'
    },
    {
      id: 3,
      name: 'LeBron James',
      sport: 'Basketball',
      position: 'Small Forward',
      team: 'Los Angeles Lakers',
      imageUrl: 'https://library.sportingnews.com/2024-02/LeBron%20James%20Lakers%20Getty%20February%202024.jpeg'
    },
    {
      id: 4,
      name: 'Stephen Curry',
      sport: 'Basketball',
      position: 'Point Guard',
      team: 'Golden State Warriors',
      imageUrl: 'https://i.iheart.com/v3/re/new_assets/65e100f7aa56b18ddf08a4f9?ops=contain&width=1200'
    },
    {
      id: 5,
      name: 'Novak Djokovic',
      sport: 'Tennis',
      position: 'Individual',
      team: 'N/A', // Lojtarët individualë nuk kanë ekip
      imageUrl: 'https://img.olympicchannel.com/images/image/private/t_1-1_760/f_auto/v1538355600/primary/g14vj948j02v7t6d5p2g'
    },
    {
      id: 6,
      name: 'Roger Federer',
      sport: 'Tennis',
      position: 'Individual',
      team: 'N/A',
      imageUrl: 'https://image.cnbcfm.com/api/v1/image/107123991-1663943343166-gettyimages-1243387829-dpa.jpeg?v=1663943486&w=929&h=523&vfry=1'
    },
    {
      id: 7,
      name: 'Max Verstappen',
      sport: 'Formula 1',
      position: 'Pilot',
      team: 'Red Bull Racing',
      imageUrl: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6s2P0zP-o_m3k2G2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E2Z9Z0p-9E&s'
    },
    {
      id: 8,
      name: 'Nikola Karabatić',
      sport: 'Handball',
      position: 'Left Back',
      team: 'Paris Saint-Germain HB',
      imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/df/Nikola_Karabatic_2017.jpg/800px-Nikola_Karabatic_2017.jpg'
    },
  ]);
  
  // Variablat reaktive për filtra dhe kërkim
  const selectedSport = ref('all');
  const selectedPosition = ref('all');
  const searchTerm = ref('');
  
  // Llogarit sportet unike të disponueshme
  const availableSports = computed(() => {
    const sports = new Set();
    allPlayers.value.forEach(player => sports.add(player.sport));
    return Array.from(sports);
  });
  
  // Llogarit pozicionet unike të disponueshme
  const availablePositions = computed(() => {
    const positions = new Set();
    allPlayers.value.forEach(player => positions.add(player.position));
    return Array.from(positions);
  });
  
  // Llogarit lojtarët e filtruar bazuar në sportin, pozicionin dhe termin e kërkimit
  const filteredPlayers = computed(() => {
    return allPlayers.value.filter(player => {
      const matchesSport = selectedSport.value === 'all' || player.sport === selectedSport.value;
      const matchesPosition = selectedPosition.value === 'all' || player.position === selectedPosition.value;
      const matchesSearch = player.name.toLowerCase().includes(searchTerm.value.toLowerCase());
      return matchesSport && matchesPosition && matchesSearch;
    });
  });
  
  // Funksioni placeholder për shikimin e detajeve të lojtarit
  const viewPlayerDetails = (playerId) => {
    alert(`Po shikon detajet për lojtarin me ID: ${playerId}. Këtu do të navigohej në një faqe detajesh.`);
    // Në të ardhmen: router.push({ name: 'player-details', params: { id: playerId } });
  };
  </script>
  
  <style scoped>
  .players-page {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
  }
  
  .filters-search-section {
    border-left: 5px solid var(--bs-primary);
  }
  
  .player-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .player-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
  }
  
  .player-photo {
    width: 100px; /* Madhësi për fotot e lojtarëve */
    height: 100px;
    object-fit: cover; /* Siguron që imazhi të mbushë zonën pa shtrembëruar */
    border-radius: 50%; /* Bëje foton rrethore */
    border: 3px solid var(--bs-primary); /* Kornizë primare rreth fotos */
    padding: 3px;
    background-color: white;
  }
  
  /* Stile shtesë për kërkimin */
  .input-group .form-control {
    border-right: none;
  }
  .input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  </style>