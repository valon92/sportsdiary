<template>
    <div class="transfers-page container my-5">
      <h1 class="text-center mb-5 text-primary fw-bold">Transferimet e Fundit</h1>
  
      <div class="filters-search-section bg-light p-4 rounded shadow-sm mb-5">
        <h4 class="mb-3 text-secondary">Filtro Transferimet</h4>
        <div class="row g-3">
          <div class="col-md-4">
            <label for="sportFilter" class="form-label">Filtro sipas Sportit:</label>
            <select id="sportFilter" class="form-select" v-model="selectedSport">
              <option value="all">Të Gjitha Sportet</option>
              <option v-for="sport in availableSports" :key="sport" :value="sport">{{ sport }}</option>
            </select>
          </div>
  
          <div class="col-md-4">
            <label for="typeFilter" class="form-label">Filtro sipas Tipit:</label>
            <select id="typeFilter" class="form-select" v-model="selectedType">
              <option value="all">Të Gjitha Tipet</option>
              <option v-for="type in availableTypes" :key="type" :value="type">{{ type }}</option>
            </select>
          </div>
  
          <div class="col-md-4">
            <label for="transferSearch" class="form-label">Kërko:</label>
            <div class="input-group">
              <input type="text" id="transferSearch" class="form-control" placeholder="Kërko lojtar/ekip..." v-model="searchTerm">
              <button class="btn btn-primary" @click="searchTerm = ''"><i class="bi bi-x-lg"></i></button>
            </div>
          </div>
        </div>
      </div>
  
      <div class="transfers-list">
        <h3 class="mb-4 text-secondary">Lëvizjet e Lojtarëve</h3>
        <div v-if="filteredTransfers.length === 0" class="alert alert-info text-center" role="alert">
          Nuk u gjetën transferime për kriteret e zgjedhura.
        </div>
        <div v-else class="list-group">
          <div v-for="transfer in filteredTransfers" :key="transfer.id" class="list-group-item list-group-item-action shadow-sm rounded-lg mb-3 transfer-item">
            <div class="d-flex align-items-center mb-2">
              <img :src="transfer.playerImageUrl" :alt="transfer.playerName + ' Photo'" class="player-transfer-photo me-3">
              <div>
                <h5 class="mb-1 fw-bold text-primary">{{ transfer.playerName }}</h5>
                <p class="mb-0 text-muted small">{{ transfer.sport }} - {{ transfer.position }}</p>
              </div>
            </div>
            <div class="d-flex justify-content-around align-items-center flex-wrap my-3">
              <div class="text-center team-transfer-info">
                <img :src="transfer.fromTeamLogo" alt="From Team Logo" class="team-transfer-logo mb-1">
                <p class="mb-0 fw-semibold text-danger">{{ transfer.fromTeamName }}</p>
              </div>
              <i class="bi bi-arrow-right-circle-fill text-primary fs-3 mx-3"></i>
              <div class="text-center team-transfer-info">
                <img :src="transfer.toTeamLogo" alt="To Team Logo" class="team-transfer-logo mb-1">
                <p class="mb-0 fw-semibold text-success">{{ transfer.toTeamName }}</p>
              </div>
            </div>
            <div class="text-center mt-2">
              <span :class="['badge', getTransferBadge(transfer.type)]">{{ transfer.type }}</span>
              <span v-if="transfer.fee" class="badge bg-dark ms-2">Vlera: {{ transfer.fee }}</span>
              <span class="badge bg-secondary ms-2">Data: {{ formatDate(transfer.date) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Të dhënat statike për transferimet
  const allTransfers = ref([
    {
      id: 1,
      playerName: 'Jude Bellingham',
      playerImageUrl: 'https://cdn.futbin.com/content/fifa24/img/players/237692.png',
      sport: 'Football',
      position: 'Mesfushor',
      fromTeamName: 'Borussia Dortmund',
      fromTeamLogo: 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/67/Borussia_Dortmund_logo.svg/1200px-Borussia_Dortmund_logo.svg.png',
      toTeamName: 'Real Madrid',
      toTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/5/56/Real_Madrid_CF.svg',
      type: 'Blerje',
      fee: '€103M',
      date: '2023-06-14'
    },
    {
      id: 2,
      playerName: 'Kai Havertz',
      playerImageUrl: 'https://img.chelseafc.com/image/upload/f_auto,q_auto:best,dpr_1.0,w_850,h_850,c_fill,g_auto/prod/assets/teams/first-team/players/Kai_Havertz_profile_22-23_cropped.png',
      sport: 'Football',
      position: 'Sulmues',
      fromTeamName: 'Chelsea FC',
      fromTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/thumb/c/cc/Chelsea_FC.svg/1200px-Chelsea_FC.svg.png',
      toTeamName: 'Arsenal FC',
      toTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/5/53/Arsenal_FC.svg',
      type: 'Blerje',
      fee: '€75M',
      date: '2023-06-28'
    },
    {
      id: 3,
      playerName: 'Declan Rice',
      playerImageUrl: 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Declan_Rice_2023.jpg/800px-Declan_Rice_2023.jpg',
      sport: 'Football',
      position: 'Mesfushor',
      fromTeamName: 'West Ham United',
      fromTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/7/7c/West_Ham_United_FC_logo.svg',
      toTeamName: 'Arsenal FC',
      toTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/5/53/Arsenal_FC.svg',
      type: 'Blerje',
      fee: '€116M',
      date: '2023-07-15'
    },
    {
      id: 4,
      playerName: 'João Cancelo',
      playerImageUrl: 'https://img.a.transfermarkt.technology/portrait/header/88315-1678129759.jpg?lm=1',
      sport: 'Football',
      position: 'Mbrojtës',
      fromTeamName: 'Manchester City',
      fromTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/e/eb/Manchester_City_FC_logo.svg',
      toTeamName: 'FC Barcelona',
      toTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg',
      type: 'Huazim',
      fee: 'N/A',
      date: '2023-09-01'
    },
    {
      id: 5,
      playerName: 'Gabriel Deck',
      playerImageUrl: 'https://www.euroleaguebasketball.net/img/player/P006240/1200x1200.jpg',
      sport: 'Basketball',
      position: 'Small Forward',
      fromTeamName: 'Oklahoma City Thunder',
      fromTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/5/5d/Oklahoma_City_Thunder.svg',
      toTeamName: 'Real Madrid Baloncesto',
      toTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/a/a2/Real_Madrid_Baloncesto_logo.svg',
      type: 'Blerje',
      fee: 'N/A',
      date: '2021-07-16'
    },
    {
      id: 6,
      playerName: 'Ousmane Dembélé',
      playerImageUrl: 'https://i.eurosport.com/2023/08/12/3762601-67897268-2560-1440.jpg',
      sport: 'Football',
      position: 'Sulmues',
      fromTeamName: 'FC Barcelona',
      fromTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/4/47/FC_Barcelona_%28crest%29.svg',
      toTeamName: 'Paris Saint-Germain',
      toTeamLogo: 'https://upload.wikimedia.org/wikipedia/en/thumb/a/a7/Paris_Saint-Germain_F.C._logo.svg/1200px-Paris_Saint-Germain_F.C._logo.svg.png',
      type: 'Blerje',
      fee: '€50M',
      date: '2023-08-12'
    }
  ]);
  
  // Variablat reaktive për filtra dhe kërkim
  const selectedSport = ref('all');
  const selectedType = ref('all');
  const searchTerm = ref('');
  
  // Llogarit sportet unike të disponueshme
  const availableSports = computed(() => {
    const sports = new Set();
    allTransfers.value.forEach(transfer => sports.add(transfer.sport));
    return Array.from(sports);
  });
  
  // Llogarit tipet unike të transferimit
  const availableTypes = computed(() => {
    const types = new Set();
    allTransfers.value.forEach(transfer => types.add(transfer.type));
    return Array.from(types);
  });
  
  // Llogarit transferimet e filtruara
  const filteredTransfers = computed(() => {
    return allTransfers.value.filter(transfer => {
      const matchesSport = selectedSport.value === 'all' || transfer.sport === selectedSport.value;
      const matchesType = selectedType.value === 'all' || transfer.type === selectedType.value;
      const matchesSearch =
        transfer.playerName.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
        transfer.fromTeamName.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
        transfer.toTeamName.toLowerCase().includes(searchTerm.value.toLowerCase());
      return matchesSport && matchesType && matchesSearch;
    });
  });
  
  // Funksion ndihmës për formatimin e datës
  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('sq-AL', options);
  };
  
  // Funksion për të kthyer klasën e badge-it bazuar në tipin e transferimit
  const getTransferBadge = (type) => {
    switch (type) {
      case 'Blerje': return 'bg-success';
      case 'Huazim': return 'bg-info';
      case 'Lirim': return 'bg-danger';
      case 'Pensionim': return 'bg-secondary';
      default: return 'bg-primary';
    }
  };
  </script>
  
  <style scoped>
  .transfers-page {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
  }
  
  .filters-search-section {
    border-left: 5px solid var(--bs-primary);
  }
  
  .transfer-item {
    background-color: white;
    border: 1px solid #dee2e6;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .transfer-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
  }
  
  .player-transfer-photo {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid var(--bs-primary);
    padding: 2px;
    background-color: white;
  }
  
  .team-transfer-logo {
    width: 50px;
    height: 50px;
    object-fit: contain;
    margin-bottom: 5px;
  }
  
  .team-transfer-info {
      min-width: 100px; /* Siguron që emrat e ekipeve të mos shtypen shumë */
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