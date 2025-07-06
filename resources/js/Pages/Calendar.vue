<template>
    <div class="calendar-page container my-5">
      <h1 class="text-center mb-5 text-primary fw-bold">Kalendari i Ngjarjeve Sportive</h1>
  
      <div class="date-selector-section bg-light p-4 rounded shadow-sm mb-5 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <h4 class="mb-3 mb-md-0 text-secondary">Zgjidh Datën:</h4>
        <div class="d-flex align-items-center">
          <button @click="previousDay" class="btn btn-outline-primary me-2"><i class="bi bi-arrow-left-circle"></i></button>
          <input type="date" class="form-control" v-model="selectedDate" @change="fetchEventsForDate">
          <button @click="nextDay" class="btn btn-outline-primary ms-2"><i class="bi bi-arrow-right-circle"></i></button>
        </div>
        <button @click="goToToday" class="btn btn-info ms-0 mt-3 ms-md-3 mt-md-0"><i class="bi bi-calendar-check me-1"></i> Sot</button>
      </div>
  
      <div class="events-list">
        <h3 class="mb-4 text-secondary">Ngjarjet për {{ formattedSelectedDate }}</h3>
        <div v-if="filteredEvents.length === 0" class="alert alert-info text-center" role="alert">
          Nuk ka ngjarje të planifikuara për këtë datë.
        </div>
        <div v-else class="list-group">
          <div v-for="event in filteredEvents" :key="event.id" class="list-group-item list-group-item-action shadow-sm rounded-lg mb-3 event-item">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1 fw-bold text-primary">{{ event.title }}</h5>
              <small class="text-muted">{{ formatTime(event.time) }}</small>
            </div>
            <p class="mb-1 text-secondary">{{ event.description }}</p>
            <small class="text-info"><i class="bi bi-geo-alt-fill me-1"></i>{{ event.location }}</small>
            <span v-if="event.sport" :class="['badge', 'ms-auto', getSportBadge(event.sport)]">{{ event.sport }}</span>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, watch, onMounted } from 'vue';
  
  // Funksion ndihmës për të formatuar datën në YYYY-MM-DD
  // Kjo funksion u rregullua për të shmangur problemet e zonës kohore.
  const getFormattedDate = (date) => {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
  };
  
  // Data e zgjedhur (default është sot)
  const selectedDate = ref(getFormattedDate(new Date()));
  
  // Të dhënat statike për ngjarjet
  const allEvents = ref([
    {
      id: 1,
      title: 'Ndeshja e Futbollit: Real Madrid vs. Barcelona',
      description: 'La Liga - El Clásico, ndeshja më e madhe e sezonit.',
      date: '2025-07-06',
      time: '21:00',
      location: 'Santiago Bernabéu, Madrid',
      sport: 'Football'
    },
    {
      id: 2,
      title: 'Finalja e Basketbollit: NBA Playoffs',
      description: 'Ndeshja e 7-të e Finales NBA.',
      date: '2025-07-06',
      time: '03:00', // Dita tjetër sipas kohës lokale
      location: 'FTX Arena, Miami',
      sport: 'Basketball'
    },
    {
      id: 3,
      title: 'Turneu i Tenisit: Wimbledon',
      description: 'Çerekfinalja e turneut të Wimbledonit.',
      date: '2025-07-07', // Kjo ngjarje është për një ditë tjetër
      time: '14:00',
      location: 'All England Club, Londër',
      sport: 'Tennis'
    },
    {
      id: 4,
      title: 'Gara e Formula 1: Britania e Madhe Grand Prix',
      description: 'Gara kryesore në qarkun Silverstone.',
      date: '2025-07-13', // Kjo ngjarje është për një ditë tjetër
      time: '15:00',
      location: 'Silverstone Circuit, Britani e Madhe',
      sport: 'Formula 1'
    },
    {
      id: 5,
      title: 'Ndeshja e Volejbollit: Kampionati Botëror',
      description: 'Faza e grupeve e Kampionatit Botëror të Volejbollit.',
      date: '2025-07-06',
      time: '19:30',
      location: 'Arena Kombëtare, Tokio',
      sport: 'Volleyball'
    },
     {
      id: 6,
      title: 'Ndeshja e Futbollit: Prishtina vs. Drita',
      description: 'Superliga e Kosovës - Derbi i qytetit.',
      date: '2025-07-06',
      time: '17:00',
      location: 'Stadiumi Fadil Vokrri, Prishtinë',
      sport: 'Football'
    }
  ]);
  
  // Llogarit ngjarjet e filtruara bazuar në datën e zgjedhur
  const filteredEvents = computed(() => {
    return allEvents.value.filter(event => event.date === selectedDate.value);
  });
  
  // Formaton datën e zgjedhur për shfaqje
  const formattedSelectedDate = computed(() => {
    const date = new Date(selectedDate.value + 'T00:00:00'); // Shto kohën për të shmangur problemet e zonës kohore
    const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
    return date.toLocaleDateString('sq-AL', options);
  });
  
  // Funksion për të kaluar te dita e mëparshme
  const previousDay = () => {
    const current = new Date(selectedDate.value + 'T00:00:00'); // Shto kohën për llogaritje të saktë
    current.setDate(current.getDate() - 1);
    selectedDate.value = getFormattedDate(current);
  };
  
  // Funksion për të kaluar te dita tjetër
  const nextDay = () => {
    const current = new Date(selectedDate.value + 'T00:00:00'); // Shto kohën për llogaritje të saktë
    current.setDate(current.getDate() + 1);
    selectedDate.value = getFormattedDate(current);
  };
  
  // Funksion për të shkuar te dita e sotme
  const goToToday = () => {
    selectedDate.value = getFormattedDate(new Date());
  };
  
  // Funksion për të marrë ngjarjet për datën e re (aktivizohet kur ndryshon inputi i datës)
  const fetchEventsForDate = () => {
    // Në një aplikacion real, këtu do të bëhej një kërkesë në backend
    // për të marrë ngjarjet e lidhura me selectedDate.value.
    console.log(`Duke marrë ngjarjet për datën: ${selectedDate.value}`);
  };
  
  // Funksion ndihmës për formatimin e kohës
  const formatTime = (timeString) => {
    // Supozojmë timeString është në formatin "HH:MM"
    if (!timeString) return 'Koha e Panjohur';
    return timeString;
  };
  
  // Funksion për të kthyer klasën e badge-it bazuar në sportin
  const getSportBadge = (sport) => {
    switch (sport) {
      case 'Football': return 'bg-success';
      case 'Basketball': return 'bg-info';
      case 'Tennis': return 'bg-warning text-dark';
      case 'Formula 1': return 'bg-danger';
      case 'Volleyball': return 'bg-primary';
      default: return 'bg-secondary';
    }
  };
  
  // Vëzhgo ndryshimet e datës së zgjedhur në mënyrë programatike (nga butonat)
  // Opcioni `{ immediate: true }` siguron që `fetchEventsForDate` të thirret menjëherë pas inicializimit.
  watch(selectedDate, (newDate, oldDate) => {
    if (newDate !== oldDate) {
      fetchEventsForDate();
    }
  }, { immediate: true }); // Kjo është çelësi për inicializimin e ngjarjeve
  
  </script>
  
  <style scoped>
  .calendar-page {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
  }
  
  .date-selector-section {
    border-left: 5px solid var(--bs-primary);
  }
  
  .date-selector-section .form-control {
    max-width: 200px;
    text-align: center;
  }
  
  .event-item {
    background-color: white;
    border: 1px solid #dee2e6;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    display: flex;
    flex-direction: column;
  }
  
  .event-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
  }
  
  .event-item .badge {
    align-self: flex-end; /* Pozicionon badge-in në fund djathtas */
    margin-top: 10px; /* Hapësirë lart */
  }
  
  /* Stile për responsivitet */
  @media (max-width: 767.98px) {
    .date-selector-section {
      flex-direction: column;
      align-items: stretch;
    }
    .date-selector-section .d-flex {
      width: 100%;
      justify-content: space-between;
      margin-bottom: 1rem;
    }
    .date-selector-section .btn {
      flex-grow: 1;
    }
    .date-selector-section input[type="date"] {
      flex-grow: 2;
      margin: 0 5px;
    }
    .date-selector-section .ms-md-3 {
      margin-left: 0 !important;
    }
  }
  </style>