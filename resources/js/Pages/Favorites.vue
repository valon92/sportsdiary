<template>
    <div class="favorites-page container my-5">
      <h1 class="text-center mb-5 text-primary fw-bold">Të Preferuarat e Mia</h1>
  
      <ul class="nav nav-pills nav-justified mb-4" id="favoritesTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            :class="{ 'active': activeTab === 'news' }"
            @click="activeTab = 'news'"
            id="news-tab"
            type="button"
            role="tab"
            aria-controls="news-content"
            aria-selected="true"
          >
            <i class="bi bi-newspaper me-2"></i>Lajme
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            :class="{ 'active': activeTab === 'spotlight' }"
            @click="activeTab = 'spotlight'"
            id="spotlight-tab"
            type="button"
            role="tab"
            aria-controls="spotlight-content"
            aria-selected="false"
          >
            <i class="bi bi-play-btn me-2"></i>Spotlight
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            :class="{ 'active': activeTab === 'results' }"
            @click="activeTab = 'results'"
            id="results-tab"
            type="button"
            role="tab"
            aria-controls="results-content"
            aria-selected="false"
          >
            <i class="bi bi-trophy me-2"></i>Rezultate
          </button>
        </li>
        </ul>
  
      <div class="tab-content" id="favoritesTabContent">
        <div class="tab-pane fade" :class="{ 'show active': activeTab === 'news' }" id="news-content" role="tabpanel" aria-labelledby="news-tab">
          <h3 class="mb-4 text-secondary">Lajmet e Preferuara</h3>
          <div v-if="favoriteNews.length === 0" class="alert alert-info text-center" role="alert">
            Nuk keni shtuar ende asnjë lajm në të preferuara.
          </div>
          <div v-else class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col" v-for="newsItem in favoriteNews" :key="newsItem.id">
              <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden favorite-item-card">
                <img :src="newsItem.imageUrl" class="card-img-top object-fit-cover" alt="News Image" style="height: 180px;">
                <div class="card-body">
                  <h5 class="card-title fw-bold text-primary text-truncate">{{ newsItem.title }}</h5>
                  <p class="card-text text-muted small mb-2"><i class="bi bi-calendar me-1"></i> {{ formatDate(newsItem.date) }}</p>
                  <p class="card-text">{{ truncateDescription(newsItem.description, 80) }}</p>
                </div>
                <div class="card-footer bg-light border-0 d-flex justify-content-between align-items-center">
                  <button class="btn btn-outline-primary btn-sm">Lexo Më Shumë</button>
                  <button @click="removeFavorite('news', newsItem.id)" class="btn btn-danger btn-sm">
                    <i class="bi bi-heart-fill me-1"></i>Hiq
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
  
        <div class="tab-pane fade" :class="{ 'show active': activeTab === 'spotlight' }" id="spotlight-content" role="tabpanel" aria-labelledby="spotlight-tab">
          <h3 class="mb-4 text-secondary">Momentet Spotlight të Preferuara</h3>
          <div v-if="favoriteSpotlight.length === 0" class="alert alert-info text-center" role="alert">
            Nuk keni shtuar ende asnjë moment spotlight në të preferuara.
          </div>
          <div v-else class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <div class="col" v-for="moment in favoriteSpotlight" :key="moment.id">
              <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden favorite-item-card">
                <img :src="moment.thumbnailUrl" class="card-img-top object-fit-cover" alt="Spotlight Thumbnail" style="height: 180px;">
                <div class="card-body">
                  <h5 class="card-title fw-bold text-primary text-truncate">{{ moment.title }}</h5>
                  <p class="card-text text-muted small">{{ moment.sport }}</p>
                </div>
                <div class="card-footer bg-light border-0 d-flex justify-content-between align-items-center">
                  <button class="btn btn-outline-primary btn-sm">Shiko Videon</button>
                  <button @click="removeFavorite('spotlight', moment.id)" class="btn btn-danger btn-sm">
                    <i class="bi bi-heart-fill me-1"></i>Hiq
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
  
        <div class="tab-pane fade" :class="{ 'show active': activeTab === 'results' }" id="results-content" role="tabpanel" aria-labelledby="results-tab">
          <h3 class="mb-4 text-secondary">Rezultatet e Preferuara</h3>
          <div v-if="favoriteResults.length === 0" class="alert alert-info text-center" role="alert">
            Nuk keni shtuar ende asnjë rezultat në të preferuara.
          </div>
          <div v-else class="row row-cols-1 g-3">
            <div class="col" v-for="result in favoriteResults" :key="result.id">
              <div class="list-group-item list-group-item-action shadow-sm rounded favorite-item-list">
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
                <div class="text-end mt-3">
                  <button @click="removeFavorite('results', result.id)" class="btn btn-danger btn-sm">
                    <i class="bi bi-heart-fill me-1"></i>Hiq
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Të dhëna statike për të preferuarat
  // Këto do të zëvendësohen me të dhëna nga backend-i dhe llogaria e përdoruesit
  const favoriteNews = ref([
    {
      id: 1,
      title: 'Benzema: Rrugëtimi im me Topin e Artë',
      description: 'Një intervistë ekskluzive me Karim Benzeman pas fitores së tij të Topit të Artë...',
      imageUrl: 'https://images.rtl.fr/~c/720v480/rtl/www/1344426-karim-benzema-brandit-son-ballon-d-or-le-17-octobre-2022.jpg',
      date: '2025-07-06',
      category: 'Futboll'
    },
    {
      id: 4,
      title: 'Chelsea shpenzon 100 milionë për yllin e ri!',
      description: 'Detajet e transferimit të bujshëm që tronditi tregun e futbollit europian...',
      imageUrl: 'https://e0.pxfuel.com/wallpapers/119/205/desktop-wallpaper-football-background-chelsea-fc-thumbnail.jpg',
      date: '2025-07-03',
      category: 'Futboll'
    }
  ]);
  
  const favoriteSpotlight = ref([
    {
      id: 101,
      title: 'Messi Gol me Volley Spektakolar',
      sport: 'Football',
      thumbnailUrl: 'https://cdn.shopify.com/s/files/1/0088/3371/2471/articles/Lionel_Messi_Goal.jpg?v=1672621740',
      videoUrl: 'https://www.youtube.com/embed/VIDEO_ID_MESSI'
    },
    {
      id: 103,
      title: 'Basketboll: Përmbysje e Çmendur në 3 Sekonda',
      sport: 'Basketball',
      thumbnailUrl: 'https://e0.pxfuel.com/wallpapers/185/877/desktop-wallpaper-basket-ball.jpg',
      videoUrl: 'https://www.youtube.com/embed/VIDEO_ID_BASKETBALL'
    }
  ]);
  
  const favoriteResults = ref([
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
      status: 'Përfunduar'
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
      status: 'Në Vazhdim'
    }
  ]);
  
  // Tab-i aktiv aktualisht
  const activeTab = ref('news'); // Mund të jetë 'news', 'spotlight', 'results'
  
  // Funksione ndihmëse
  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('sq-AL', options);
  };
  
  const truncateDescription = (description, maxLength) => {
    if (description.length > maxLength) {
      return description.substring(0, maxLength) + '...';
    }
    return description;
  };
  
  const getStatusBadge = (status) => {
    switch (status) {
      case 'Përfunduar': return 'bg-success';
      case 'Në Vazhdim': return 'bg-warning text-dark';
      case 'Në Pritje': return 'bg-info';
      default: return 'bg-secondary';
    }
  };
  
  // Funksioni për të hequr një element nga të preferuarat
  const removeFavorite = (type, id) => {
    if (confirm(`A jeni i sigurt që dëshironi ta hiqni këtë nga të preferuarat?`)) {
      if (type === 'news') {
        favoriteNews.value = favoriteNews.value.filter(item => item.id !== id);
      } else if (type === 'spotlight') {
        favoriteSpotlight.value = favoriteSpotlight.value.filter(item => item.id !== id);
      } else if (type === 'results') {
        favoriteResults.value = favoriteResults.value.filter(item => item.id !== id);
      }
      // Këtu do të dërgohej kërkesa në backend për të fshirë realisht nga baza e të dhënave
      alert('Elementi u hoq nga të preferuarat (frontend only).');
    }
  };
  </script>
  
  <style scoped>
  .favorites-page {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
  }
  
  .nav-pills .nav-link {
    color: #6c757d; /* Ngjyra e butoneve jo-aktiv */
    font-weight: 500;
    transition: all 0.3s ease;
  }
  
  .nav-pills .nav-link.active {
    background-color: var(--bs-primary);
    color: white;
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
  }
  
  .favorite-item-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .favorite-item-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
  }
  
  .favorite-item-list {
    background-color: white;
    padding: 1.25rem;
    border: 1px solid #dee2e6;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .favorite-item-list:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
  }
  
  .team-logo {
    width: 40px;
    height: 40px;
    object-fit: contain;
  }
  
  .score-info h3 {
    font-size: 2rem;
  }
  
  .object-fit-cover {
    object-fit: cover;
  }
  
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