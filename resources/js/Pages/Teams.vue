<template>
    <div class="teams-page container my-5">
      <h1 class="text-center mb-5 text-primary fw-bold">Ekipet Sportive</h1>
  
      <div class="filters-search-section bg-light p-4 rounded shadow-sm mb-5">
        <h4 class="mb-3 text-secondary">Gjej Ekipe</h4>
        <div class="row g-3 align-items-center">
          <div class="col-md-5">
            <label for="sportFilter" class="form-label">Filtro sipas Sportit:</label>
            <select id="sportFilter" class="form-select" v-model="selectedSport">
              <option value="all">Të Gjitha Sportet</option>
              <option v-for="sport in availableSports" :key="sport" :value="sport">{{ sport }}</option>
            </select>
          </div>
  
          <div class="col-md-7">
            <label for="teamSearch" class="form-label">Kërko Ekip:</label>
            <div class="input-group">
              <input type="text" id="teamSearch" class="form-control" placeholder="Kërko sipas emrit të ekipit..." v-model="searchTerm">
              <button class="btn btn-primary" @click="searchTerm = ''"><i class="bi bi-x-lg"></i></button>
            </div>
          </div>
        </div>
      </div>
  
      <div class="teams-list">
        <h3 class="mb-4 text-secondary">Ekipet e Gjetura</h3>
        <div v-if="filteredTeams.length === 0" class="alert alert-info text-center" role="alert">
          Nuk u gjetën ekipe për kriteret e zgjedhura.
        </div>
        <div v-else class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
          <div class="col" v-for="team in filteredTeams" :key="team.id">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden team-card text-center">
              <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                <img :src="team.logoUrl" :alt="team.name + ' Logo'" class="team-logo mb-3">
                <h5 class="card-title fw-bold mb-1 text-primary">{{ team.name }}</h5>
                <p class="card-text text-muted small mb-0">{{ team.sport }} - {{ team.league }}</p>
              </div>
              <div class="card-footer bg-light border-0">
                  <button @click="viewTeamDetails(team.id)" class="btn btn-outline-primary btn-sm w-100">Shiko Detajet</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Të dhënat statike për ekipet
  const allTeams = ref([
    {
      id: 1,
      name: 'Real Madrid',
      sport: 'Football',
      league: 'La Liga',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg'
    },
    {
      id: 2,
      name: 'FC Barcelona',
      sport: 'Football',
      league: 'La Liga',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg'
    },
    {
      id: 3,
      name: 'Manchester United',
      sport: 'Football',
      league: 'Premier League',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7a/Manchester_United_FC_crest.svg/1200px-Manchester_United_FC_crest.svg.png'
    },
    {
      id: 4,
      name: 'Liverpool FC',
      sport: 'Football',
      league: 'Premier League',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/0/0c/Liverpool_FC.svg'
    },
    {
      id: 5,
      name: 'Los Angeles Lakers',
      sport: 'Basketball',
      league: 'NBA',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/commons/3/3c/Los_Angeles_Lakers_logo.svg'
    },
    {
      id: 6,
      name: 'Boston Celtics',
      sport: 'Basketball',
      league: 'NBA',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/8/8f/Boston_Celtics.svg'
    },
    {
      id: 7,
      name: 'Golden State Warriors',
      sport: 'Basketball',
      league: 'NBA',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/0/01/Golden_State_Warriors_logo.svg'
    },
    {
      id: 8,
      name: 'Milwaukee Bucks',
      sport: 'Basketball',
      league: 'NBA',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/4/4a/Milwaukee_Bucks_logo.svg'
    },
    {
      id: 9,
      name: 'Vardar 1961',
      sport: 'Handball',
      league: 'Champions League',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/thumb/4/4e/RK_Vardar_1961_logo.png/600px-RK_Vardar_1961_logo.png'
    },
    {
      id: 10,
      name: 'Barça (Handball)',
      sport: 'Handball',
      league: 'Champions League',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d1/FC_Barcelona_handball_logo.svg/1200px-FC_Barcelona_handball_logo.svg.png'
    },
    {
      id: 11,
      name: 'Paris Saint-Germain (Handball)',
      sport: 'Handball',
      league: 'Champions League',
      logoUrl: 'https://upload.wikimedia.org/wikipedia/en/thumb/7/7b/Paris_Saint-Germain_HB_logo.svg/1200px-Paris_Saint-Germain_HB_logo.svg.png'
    }
  ]);
  
  // Variablat reaktive për filtra dhe kërkim
  const selectedSport = ref('all');
  const searchTerm = ref('');
  
  // Llogarit sportet unike të disponueshme nga të dhënat
  const availableSports = computed(() => {
    const sports = new Set();
    allTeams.value.forEach(team => sports.add(team.sport));
    return Array.from(sports);
  });
  
  // Llogarit ekipet e filtruara bazuar në sportin e zgjedhur dhe termin e kërkimit
  const filteredTeams = computed(() => {
    return allTeams.value.filter(team => {
      const matchesSport = selectedSport.value === 'all' || team.sport === selectedSport.value;
      const matchesSearch = team.name.toLowerCase().includes(searchTerm.value.toLowerCase());
      return matchesSport && matchesSearch;
    });
  });
  
  // Funksioni placeholder për shikimin e detajeve të ekipit
  const viewTeamDetails = (teamId) => {
    alert(`Po shikon detajet për ekipin me ID: ${teamId}. Këtu do të navigohej në një faqe detajesh.`);
    // Në të ardhmen: router.push({ name: 'team-details', params: { id: teamId } });
  };
  </script>
  
  <style scoped>
  .teams-page {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
  }
  
  .filters-search-section {
    border-left: 5px solid var(--bs-primary);
  }
  
  .team-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
  }
  
  .team-logo {
    width: 90px; /* Madhësi pak më e madhe për logot e ekipit */
    height: 90px;
    object-fit: contain;
    border: 1px solid #eee; /* Një kornizë e lehtë rreth logos */
    border-radius: 50%; /* Bëje rrethore nëse logoja është katrore */
    padding: 5px;
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