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
                
                <div class="interaction-section border-top mt-3 pt-3 d-flex justify-content-around align-items-center">
                  <div class="text-center">
                    <i class="bi bi-heart-fill text-danger me-1"></i>
                    <span class="fw-semibold">{{ featuredNews[0].likes }}</span>
                  </div>
                  <div class="text-center">
                    <i class="bi bi-chat-dots-fill text-secondary me-1"></i>
                    <span class="fw-semibold">{{ featuredNews[0].comments }}</span>
                  </div>
                  <div class="text-center">
                    <i class="bi bi-share-fill text-info me-1"></i>
                    <span class="fw-semibold">{{ featuredNews[0].shares }}</span>
                  </div>
                </div>
                <div class="d-flex border-top mt-2">
                  <button @click="handleLike(featuredNews[0].id)" class="btn btn-link flex-fill text-decoration-none text-primary py-2 px-0 border-end">
                    <i class="bi bi-hand-thumbs-up fs-5"></i> <span class="d-none d-sm-inline ms-1">Pëlqe</span>
                  </button>
                  <button @click="handleComment(featuredNews[0].id)" class="btn btn-link flex-fill text-decoration-none text-secondary py-2 px-0 border-end">
                    <i class="bi bi-chat fs-5"></i> <span class="d-none d-sm-inline ms-1">Koment</span>
                  </button>
                  <button @click="handleShare(featuredNews[0].id)" class="btn btn-link flex-fill text-decoration-none text-info py-2 px-0">
                    <i class="bi bi-share fs-5"></i> <span class="d-none d-sm-inline ms-1">Shpërnda</span>
                  </button>
                </div>
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
                       <div class="d-flex justify-content-start gap-3 small text-muted">
                          <div><i class="bi bi-heart-fill text-danger"></i> {{ newsItem.likes }}</div>
                          <div><i class="bi bi-chat-dots-fill text-secondary"></i> {{ newsItem.comments }}</div>
                      </div>
                      <button @click="handleLike(newsItem.id)" class="btn btn-sm btn-outline-primary mt-2">Lexo & Ndërvepro</button>
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
                  <div class="d-flex justify-content-between align-items-center mb-2">
                      <div class="text-center me-2">
                          <i class="bi bi-heart-fill text-danger me-1"></i>
                          <span class="fw-semibold">{{ newsItem.likes }}</span>
                      </div>
                      <div class="text-center me-2">
                          <i class="bi bi-chat-dots-fill text-secondary me-1"></i>
                          <span class="fw-semibold">{{ newsItem.comments }}</span>
                      </div>
                      <div class="text-center">
                          <i class="bi bi-share-fill text-info me-1"></i>
                          <span class="fw-semibold">{{ newsItem.shares }}</span>
                      </div>
                  </div>
                  <div class="d-flex">
                      <button @click="handleLike(newsItem.id)" class="btn btn-link flex-fill text-decoration-none text-primary py-1 px-0 border-end">
                          <i class="bi bi-hand-thumbs-up"></i>
                      </button>
                      <button @click="handleComment(newsItem.id)" class="btn btn-link flex-fill text-decoration-none text-secondary py-1 px-0 border-end">
                          <i class="bi bi-chat"></i>
                      </button>
                      <button @click="handleShare(newsItem.id)" class="btn btn-link flex-fill text-decoration-none text-info py-1 px-0">
                          <i class="bi bi-share"></i>
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
  
  // Të dhëna statike për lajmet
  const allNews = ref([
    {
      id: 1,
      title: 'Benzema: Rrugëtimi im me Topin e Artë',
      description: 'Një intervistë ekskluzive me Karim Benzeman pas fitores së tij të Topit të Artë, ku ai flet për sfidat, momentet kyçe dhe ambiciet e tij. Kjo është një histori frymëzuese për të gjithë adhuruesit e futbollit, duke treguar përkushtimin dhe punën e palodhur drejt majave të suksesit.',
      imageUrl: 'https://images.rtl.fr/~c/720v480/rtl/www/1344426-karim-benzema-brandit-son-ballon-d-or-le-17-octobre-2022.jpg',
      date: '2025-07-06',
      category: 'Futboll',
      likes: 250, comments: 75, shares: 30
    },
    {
      id: 2,
      title: 'LeBron James, ende Mbret i NBA?',
      description: 'Analizë e thelluar e ndikimit të LeBron James në ligën NBA dhe a mund të mbajë ende kurorën si lojtari më i mirë. Me moshën që rritet, performanca e tij vazhdon të jetë e jashtëzakonshme, duke sfiduar pritshmëritë dhe duke vendosur standarde të reja.',
      imageUrl: 'https://image-cdn.hypb.st/https%3A%2F%2Fhypebeast.com%2Fimage%2F2020%2F10%2Flebron-james-wins-fourth-nba-championship-fourth-finals-mvp-title-001.jpg?cbr=1&q=90&w=750&fit=max',
      date: '2025-07-05',
      category: 'Basketboll',
      likes: 180, comments: 60, shares: 25
    },
    {
      id: 3,
      title: 'Djokovic arrin rekord të ri në Wimbledon',
      description: 'Novak Djokovic shkruan historinë në Wimbledon, duke thyer një tjetër rekord në karrierën e tij të jashtëzakonshme. Kjo arritje e konfirmon atë si një nga tenistët më të mëdhenj të të gjitha kohërave, me një dominim të vazhdueshëm në Grand Slam-e.',
      imageUrl: 'https://i.guim.co.uk/img/media/e4b4b2c12d4d9c7c2e3d3c8c7b8f9e6f0f0f0f0f/0_200_6000_3600/master/6000.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=5a4e0c7a8b4c7c7c7c7c7c7c7c7c7c7c',
      date: '2025-07-04',
      category: 'Tenis',
      likes: 150, comments: 40, shares: 15
    },
    {
      id: 4,
      title: 'Chelsea shpenzon 100 milionë për yllin e ri!',
      description: 'Detajet e transferimit të bujshëm që tronditi tregun e futbollit europian. Si do të ndikojë ky transferim në strategjinë e ekipit? Një lëvizje e guximshme nga Chelsea, e cila sinjalizon ambiciet e tyre për të konkurruar në nivelet më të larta.',
      imageUrl: 'https://e0.pxfuel.com/wallpapers/119/205/desktop-wallpaper-football-background-chelsea-fc-thumbnail.jpg',
      date: '2025-07-03',
      category: 'Futboll',
      likes: 300, comments: 90, shares: 40
    },
    {
      id: 5,
      title: 'Konfirmohet: NBA do të zgjerohet me dy ekipe!',
      description: 'Një lajm historik për ligën e basketbollit NBA, me planet për zgjerim dhe impaktin e tyre në të ardhmen e sportit. Kjo do të sjellë më shumë ndeshje, talentë të rinj dhe mundësi të reja për fansat në mbarë botën.',
      imageUrl: 'https://sportsprediction.com/wp-content/uploads/2023/11/nba-expansion.jpg',
      date: '2025-07-02',
      category: 'Basketboll',
      likes: 110, comments: 35, shares: 12
    },
    {
      id: 6,
      title: 'Formula 1: Dominimi i Verstappen vazhdon',
      description: 'Analiza e garës së fundit të Formula 1 dhe pse Max Verstappen mbetet i pathyeshëm këtë sezon. Performanca e tij dominuese e ka bërë atë një forcë të pakonkurueshme, duke vendosur rekorde të reja dhe duke lënë konkurrentët pas.',
      imageUrl: 'https://media.formula1.com/image/upload/f_auto,c_limit,w_1920,q_auto/f_auto/q_auto/redbullcom/2024/02/130138/image_grid_thumbnail/Red%20Bull%20Racing%20Car%20Launch%202024',
      date: '2025-07-01',
      category: 'Formula 1',
      likes: 95, comments: 20, shares: 8
    },
    {
      id: 7,
      title: 'Suksesi i Kupës së Botës për Femra',
      description: 'Një vështrim mbi suksesin dhe rritjen e ndjekshmërisë së Kupës së Botës për Femra në vitet e fundit. Turneu ka shënuar rekorde të shikueshmërisë dhe ka frymëzuar miliona vajza dhe gra në mbarë botën të merren me futboll.',
      imageUrl: 'https://i.guim.co.uk/img/media/b69576f3f00a5a3a4b0a8f8e0d6e6f1a8e6e8e8e/0_0_5760_3456/master/5760.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=5c5e5e5e5e5e5e5e5e5e5e5e5e5e5e5e',
      date: '2025-06-30',
      category: 'Futboll',
      likes: 190, comments: 55, shares: 20
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
  
  // Funksionet placeholder për ndërveprimet
  const handleLike = (newsId) => {
    alert(`Pëlqeve lajmin me ID: ${newsId}! Funksionaliteti do të lidhet me backend.`);
  };
  
  const handleComment = (newsId) => {
    alert(`Po komenton për lajmin me ID: ${newsId}! Funksionaliteti do të lidhet me backend.`);
  };
  
  const handleShare = (newsId) => {
    alert(`Po shpërndan lajmin me ID: ${newsId}! Funksionaliteti do të lidhet me backend.`);
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
  
  .featured-card, .news-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .featured-card:hover, .news-card:hover {
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
  
  .object-fit-cover {
    object-fit: cover;
  }
  
  /* Stile të reja për seksionin e ndërveprimit */
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
  
  /* Stile shtesë për numrat e ndërveprimit në kartat e vogla të theksuara */
  .small-featured-card .d-flex.gap-3.small {
      margin-top: 5px; /* Pak hapësirë sipër */
      font-size: 0.8rem; /* Font më i vogël */
  }
  
  .small-featured-card .d-flex.gap-3.small i {
      font-size: 0.9rem; /* Ikonë më e vogël */
  }
  </style>