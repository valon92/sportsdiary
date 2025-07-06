<template>
    <div class="news-page container my-5">
      <h1 class="text-center mb-5 text-primary fw-bold">Lajmet e Fundit nga Bota e Sportit</h1>
  
      <div class="featured-news-section mb-5">
        <h3 class="mb-4 text-secondary">Lajmet Kryesore</h3>
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden featured-card">
              <img :src="featuredNews[0].imageUrl" class="card-img-top object-fit-cover" alt="Featured News Image" style="height: 350px;">
              <div class="card-body">
                <h4 class="card-title fw-bold text-primary">{{ featuredNews[0].title }}</h4>
                <p class="card-text text-muted small mb-2"><i class="bi bi-calendar me-1"></i> {{ formatDate(featuredNews[0].date) }}</p>
                <p class="card-text">{{ featuredNews[0].description }}</p>
                <button class="btn btn-primary mt-2">Lexo Më Shumë</button>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="d-flex flex-column h-100">
              <div v-for="newsItem in featuredNews.slice(1, 3)" :key="newsItem.id" class="card shadow-sm border-0 rounded-lg overflow-hidden small-featured-card mb-4">
                <div class="row g-0">
                  <div class="col-4">
                    <img :src="newsItem.imageUrl" class="img-fluid rounded-start object-fit-cover h-100" alt="News Image">
                  </div>
                  <div class="col-8">
                    <div class="card-body py-2">
                      <h6 class="card-title fw-bold mb-1">{{ newsItem.title }}</h6>
                      <p class="card-text text-muted small mb-1"><i class="bi bi-calendar me-1"></i> {{ formatDate(newsItem.date) }}</p>
                      <button class="btn btn-sm btn-outline-primary">Lexo</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <div class="categories-section bg-light p-3 rounded shadow-sm mb-5">
        <h4 class="mb-3 text-secondary">Filtro sipas Kategorisë</h4>
        <div class="d-flex flex-wrap gap-2">
          <button
            :class="['btn', selectedCategory === 'Të Gjitha' ? 'btn-primary' : 'btn-outline-primary']"
            @click="selectedCategory = 'Të Gjitha'">
            Të Gjitha
          </button>
          <button
            v-for="category in availableCategories" :key="category"
            :class="['btn', selectedCategory === category ? 'btn-primary' : 'btn-outline-primary']"
            @click="selectedCategory = category">
            {{ category }}
          </button>
        </div>
      </div>
  
      <div class="news-list">
        <h3 class="mb-4 text-secondary">Artikuj të Tjerë</h3>
        <div v-if="filteredNews.length === 0" class="alert alert-info text-center" role="alert">
          Nuk u gjetën lajme për kategorinë e zgjedhur.
        </div>
        <div v-else class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
          <div class="col" v-for="newsItem in filteredNews" :key="newsItem.id">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden news-card">
              <img :src="newsItem.imageUrl" class="card-img-top object-fit-cover" alt="News Image" style="height: 200px;">
              <div class="card-body">
                <h5 class="card-title fw-bold text-primary text-truncate">{{ newsItem.title }}</h5>
                <p class="card-text text-muted small mb-2"><i class="bi bi-calendar me-1"></i> {{ formatDate(newsItem.date) }}</p>
                <p class="card-text">{{ truncateDescription(newsItem.description, 100) }}</p>
              </div>
              <div class="card-footer bg-light border-0">
                <button class="btn btn-outline-primary btn-sm">Lexo Më Shumë</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Të dhëna statike për lajmet
  const allNews = ref([
    {
      id: 1,
      title: 'Benzema: Rrugëtimi im me Topin e Artë',
      description: 'Një intervistë ekskluzive me Karim Benzeman pas fitores së tij të Topit të Artë, ku ai flet për sfidat, momentet kyçe dhe ambiciet e tij.',
      imageUrl: 'https://images.rtl.fr/~c/720v480/rtl/www/1344426-karim-benzema-brandit-son-ballon-d-or-le-17-octobre-2022.jpg',
      date: '2025-07-06',
      category: 'Futboll'
    },
    {
      id: 2,
      title: 'LeBron James, ende Mbret i NBA?',
      description: 'Analizë e thelluar e ndikimit të LeBron James në ligën NBA dhe a mund të mbajë ende kurorën si lojtari më i mirë.',
      imageUrl: 'https://image-cdn.hypb.st/https%3A%2F%2Fhypebeast.com%2Fimage%2F2020%2F10%2Flebron-james-wins-fourth-nba-championship-fourth-finals-mvp-title-001.jpg?cbr=1&q=90&w=750&fit=max',
      date: '2025-07-05',
      category: 'Basketboll'
    },
    {
      id: 3,
      title: 'Djokovic arrin rekord të ri në Wimbledon',
      description: 'Novak Djokovic shkruan historinë në Wimbledon, duke thyer një tjetër rekord në karrierën e tij të jashtëzakonshme.',
      imageUrl: 'https://i.guim.co.uk/img/media/e4b4b2c12d4d9c7c2e3d3c8c7b8f9e6f0f0f0f0f/0_200_6000_3600/master/6000.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=5a4e0c7a8b4c7c7c7c7c7c7c7c7c7c7c',
      date: '2025-07-04',
      category: 'Tenis'
    },
    {
      id: 4,
      title: 'Chelsea shpenzon 100 milionë për yllin e ri!',
      description: 'Detajet e transferimit të bujshëm që tronditi tregun e futbollit europian. Si do të ndikojë ky transferim në strategjinë e ekipit?',
      imageUrl: 'https://e0.pxfuel.com/wallpapers/119/205/desktop-wallpaper-football-background-chelsea-fc-thumbnail.jpg',
      date: '2025-07-03',
      category: 'Futboll'
    },
    {
      id: 5,
      title: 'Konfirmohet: NBA do të zgjerohet me dy ekipe!',
      description: 'Një lajm historik për ligën e basketbollit NBA, me planet për zgjerim dhe impaktin e tyre në të ardhmen e sportit.',
      imageUrl: 'https://sportsprediction.com/wp-content/uploads/2023/11/nba-expansion.jpg',
      date: '2025-07-02',
      category: 'Basketboll'
    },
    {
      id: 6,
      title: 'Formula 1: Dominimi i Verstappen vazhdon',
      description: 'Analiza e garës së fundit të Formula 1 dhe pse Max Verstappen mbetet i pathyeshëm këtë sezon.',
      imageUrl: 'https://media.formula1.com/image/upload/f_auto,c_limit,w_1920,q_auto/f_auto/q_auto/redbullcom/2024/02/130138/image_grid_thumbnail/Red%20Bull%20Racing%20Car%20Launch%202024',
      date: '2025-07-01',
      category: 'Formula 1'
    },
    {
      id: 7,
      title: 'Suksesi i Kupës së Botës për Femra',
      description: 'Një vështrim mbi suksesin dhe rritjen e ndjekshmërisë së Kupës së Botës për Femra në vitet e fundit.',
      imageUrl: 'https://i.guim.co.uk/img/media/b69576f3f00a5a3a4b0a8f8e0d6e6f1a8e6e8e8e/0_0_5760_3456/master/5760.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=5c5e5e5e5e5e5e5e5e5e5e5e5e5e5e5e',
      date: '2025-06-30',
      category: 'Futboll'
    }
  ]);
  
  // Kategoria e zgjedhur fillimisht
  const selectedCategory = ref('Të Gjitha');
  
  // Llogarit kategoritë unike të disponueshme nga të dhënat
  const availableCategories = computed(() => {
    const categories = new Set();
    allNews.value.forEach(newsItem => categories.add(newsItem.category));
    return Array.from(categories);
  });
  
  // Llogarit lajmet e filtruara bazuar në kategorinë e zgjedhur
  const filteredNews = computed(() => {
    if (selectedCategory.value === 'Të Gjitha') {
      return allNews.value;
    }
    return allNews.value.filter(newsItem => newsItem.category === selectedCategory.value);
  });
  
  // Zgjedh lajmet e theksuara (3 lajmet e para si shembull)
  const featuredNews = computed(() => {
    return allNews.value.slice(0, 3);
  });
  
  // Funksion ndihmës për formatimin e datës
  const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('sq-AL', options);
  };
  
  // Funksion ndihmës për shkurtimin e përshkrimit
  const truncateDescription = (description, maxLength) => {
    if (description.length > maxLength) {
      return description.substring(0, maxLength) + '...';
    }
    return description;
  };
  </script>
  
  <style scoped>
  .news-page {
    background-color: #f8f9fa; /* Ngjyrë e lehtë sfondi */
    padding: 2rem;
    border-radius: 8px;
  }
  
  .featured-news-section {
    border-bottom: 3px solid var(--bs-primary); /* Një vijë poshtë seksionit kryesor */
    padding-bottom: 2rem;
  }
  
  .featured-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .featured-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
  }
  
  .small-featured-card {
    height: 100%;
  }
  
  .small-featured-card img {
    object-fit: cover;
    width: 100%;
    height: 100px; /* Lartësi fikse për imazhet e vogla */
  }
  
  .categories-section {
    border-left: 5px solid var(--bs-info); /* Një detaj vizual tjetër */
  }
  
  .news-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
  }
  
  .object-fit-cover {
    object-fit: cover;
  }
  </style>