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
  
            <div class="interaction-section mt-3 pt-3 border-top d-flex justify-content-around align-items-center">
              <button @click="toggleLike(transfer.id)" class="btn btn-outline-primary btn-sm flex-fill me-2">
                <i :class="['bi', transfer.hasLiked ? 'bi-heart-fill' : 'bi-heart']"></i>
                <span class="ms-1">{{ transfer.likes }}</span>
              </button>
              <button @click="openComments(transfer.id)" class="btn btn-outline-secondary btn-sm flex-fill mx-2">
                <i class="bi bi-chat-dots"></i>
                <span class="ms-1">{{ transfer.comments }}</span>
              </button>
              <button @click="shareTransfer(transfer.id)" class="btn btn-outline-info btn-sm flex-fill ms-2">
                <i class="bi bi-share"></i>
                <span class="ms-1">{{ transfer.shares }}</span>
              </button>
            </div>
            </div>
        </div>
      </div>
    </div>
  
    <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-primary" id="commentsModalLabel">Komente për Transferimin</h5>
            <button type="button" class="btn-close" @click="hideCommentsModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div v-if="currentTransferComments.length === 0" class="alert alert-info text-center" role="alert">
              Asnjë koment ende. Bëhu i pari!
            </div>
            <div v-else class="list-group mb-3 comments-list">
              <div v-for="comment in currentTransferComments" :key="comment.id" class="list-group-item list-group-item-light border-0 py-2">
                <div class="d-flex w-100 justify-content-between">
                  <h6 class="mb-1 fw-bold">{{ comment.user }}</h6>
                  <small class="text-muted">{{ formatDate(comment.date) }}</small>
                </div>
                <p class="mb-1">{{ comment.comment }}</p>
              </div>
            </div>
  
            <div class="comment-input-section mt-4 pt-3 border-top">
              <h6 class="mb-3 text-secondary">Shto Komentin Tënd</h6>
              <div class="input-group">
                <textarea class="form-control" rows="2" placeholder="Shkruaj komentin tënd këtu..." v-model="newCommentText"></textarea>
                <button class="btn btn-primary" @click="addComment">Posto</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import { Modal } from 'bootstrap';
  
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
      date: '2023-06-14',
      likes: 125,
      comments: 20,
      shares: 8,
      hasLiked: false // Shto këtë pronë për të menaxhuar gjendjen e pëlqimit
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
      date: '2023-06-28',
      likes: 98,
      comments: 15,
      shares: 5,
      hasLiked: false
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
      date: '2023-07-15',
      likes: 150,
      comments: 30,
      shares: 12,
      hasLiked: false
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
      date: '2023-09-01',
      likes: 70,
      comments: 10,
      shares: 3,
      hasLiked: false
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
      date: '2021-07-16',
      likes: 45,
      comments: 5,
      shares: 1,
      hasLiked: false
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
      date: '2023-08-12',
      likes: 110,
      comments: 25,
      shares: 10,
      hasLiked: false
    }
  ]);
  
  // Variablat reaktive për filtra dhe kërkim
  const selectedSport = ref('all');
  const selectedType = ref('all');
  const searchTerm = ref('');
  
  // Variablat për menaxhimin e modalit të komenteve
  const showCommentsModal = ref(false);
  const currentTransferComments = ref([]);
  const newCommentText = ref('');
  const activeTransferId = ref(null);
  let commentsModalInstance = null; // Për të ruajtur instancën e modalit
  
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
    // Shto një kontroll për vlera inekzistente të datës
    if (!dateString) return 'Data e Panjohur';
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
  
  // Funksionet e ndërveprimit
  const toggleLike = (transferId) => {
    const transfer = allTransfers.value.find(t => t.id === transferId);
    if (transfer) {
      transfer.likes = transfer.likes + (transfer.hasLiked ? -1 : 1);
      transfer.hasLiked = !transfer.hasLiked;
      // Në një aplikacion real, do të bëhej një kërkesë në backend për të ruajtur pëlqimin.
      console.log(`Transfer ID: ${transferId} - Pëlqimi u toggled. Likes: ${transfer.likes}`);
    }
  };
  
  const openComments = (transferId) => {
    activeTransferId.value = transferId;
    // Këtu do të merrnim komentet nga backend-i për këtë transferim
    // Për simulim, po i filtrojmë komentet nga një listë e madhe statike.
    const allStaticComments = [
      { id: 1, transferId: 1, user: 'Artan', comment: 'Transferim i shkëlqyer! Real Madrid bëri goditje të madhe.', date: '2023-06-15' },
      { id: 2, transferId: 1, user: 'Erion', comment: 'Shume shpenzime, a ja vlen Bellingham?', date: '2023-06-16' },
      { id: 3, transferId: 1, user: 'Mimoza', comment: 'Mendoj se do të shkëlqejë në La Liga.', date: '2023-06-17' },
      { id: 4, transferId: 2, user: 'Besnik', comment: 'Havertz tek Arsenal? Cudi!', date: '2023-06-29' },
      { id: 5, transferId: 2, user: 'Liridona', comment: 'Lëvizje e mirë për karrierën e tij.', date: '2023-06-30' },
      { id: 6, transferId: 3, user: 'Dren', comment: 'Rice vlera teper e larte, a thua ia vlen?', date: '2023-07-16' },
      { id: 7, transferId: 3, user: 'Valbona', comment: 'West Ham humbi nje lojtar fantastik.', date: '2023-07-17' },
      { id: 8, transferId: 4, user: 'Faton', comment: 'Cancelo te Barca? Huazim i zgjuar.', date: '2023-09-02' },
      { id: 9, transferId: 5, user: 'Edon', comment: 'Deck kthehet ne Europe, e prisja.', date: '2021-07-17' },
      { id: 10, transferId: 6, user: 'Fjolla', comment: 'Dembelé te PSG, pritej ky transferim.', date: '2023-08-13' },
    ];
    currentTransferComments.value = allStaticComments.filter(comment => comment.transferId === transferId);
  
    // Shfaq modale
    showCommentsModal.value = true;
    commentsModalInstance.show();
  };
  
  const addComment = () => {
    if (newCommentText.value.trim() !== '' && activeTransferId.value) {
      const newComment = {
        id: Date.now(), // ID unike e thjeshtë
        user: 'You', // Kjo do të zëvendësohej me emrin e përdoruesit të loguar
        comment: newCommentText.value.trim(),
        date: new Date().toISOString().slice(0, 10),
        transferId: activeTransferId.value // Ruaj ID-në e transferimit
      };
      currentTransferComments.value.push(newComment);
      // Në një aplikacion real, do të dërgohej komentimi në backend.
      // Dhe do të duhej të përditësohej numri i komenteve në allTransfers.
      const transfer = allTransfers.value.find(t => t.id === activeTransferId.value);
      if (transfer) {
        transfer.comments++;
      }
      newCommentText.value = ''; // Pastro fushën e komentit
      console.log('Komenti u shtua:', newComment);
    }
  };
  
  const hideCommentsModal = () => {
    showCommentsModal.value = false;
    newCommentText.value = ''; // Pastro fushën e komentit
    activeTransferId.value = null; // Pastro transfer id
    commentsModalInstance.hide();
  };
  
  const shareTransfer = (transferId) => {
    const transferLink = `${window.location.origin}/transfers/${transferId}`;
    navigator.clipboard.writeText(transferLink)
      .then(() => {
        alert(`Lidhja e transferimit u kopjua: ${transferLink}`);
        const transfer = allTransfers.value.find(t => t.id === transferId);
        if (transfer) {
          transfer.shares++; // Rrit numrin e shpërndarjeve
        }
      })
      .catch(err => {
        console.error('Nuk mund të kopjohej lidhja: ', err);
        alert('Nuk mund të kopjohej lidhja. Ju lutemi provoni manualisht.');
      });
  };
  
  // Inicializo Bootstrap Modal kur komponenti është montuar
  onMounted(() => {
    commentsModalInstance = new Modal(document.getElementById('commentsModal'));
  
    // Shto një listener për kur modali mbyllet manualisht nga user-i
    const commentsModalElement = document.getElementById('commentsModal');
    commentsModalElement.addEventListener('hidden.bs.modal', () => {
      // Vetëm pastro gjendjen kur modali mbyllet nga Bootstrap
      if (showCommentsModal.value) { // Shmange ekzekutimin e dyfishtë
        showCommentsModal.value = false;
        newCommentText.value = '';
        activeTransferId.value = null;
      }
    });
  });
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
  
  /* Stile për seksionin e ndërveprimit */
  .interaction-section .btn {
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .interaction-section .btn i {
    font-size: 1rem;
  }
  
  .interaction-section .btn span {
    font-weight: bold;
  }
  
  /* Stile për modalin e komenteve */
  .comments-list .list-group-item:nth-child(even) {
    background-color: #f1f1f1; /* Ngjyrë e lehtë alternuese */
  }
  
  .comments-list .list-group-item:last-child {
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
  }
  
  .modal-content {
    border-radius: 0.75rem;
    overflow: hidden;
  }
  
  .modal-header {
    background-color: var(--bs-primary);
    color: white;
    border-bottom: none;
  }
  
  .modal-header .btn-close {
    filter: invert(1); /* Për të bërë X të bardhë */
  }
  
  .comment-input-section .input-group textarea {
    border-right: none;
  }
  .comment-input-section .input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  </style>