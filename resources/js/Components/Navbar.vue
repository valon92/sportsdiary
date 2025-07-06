<template>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <router-link class="navbar-brand text-success fw-bold fs-3" to="/">
       <!-- <i class="bi bi-calendar-check-fill me-2"></i> -->
         Sportday
      </router-link>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-none d-lg-flex flex-grow-1 justify-content-center">
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home">
              <i class="bi bi-house-fill"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/spotlight" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Spotlight">
              <i class="bi bi-camera-reels-fill"></i>
            </router-link>
          </li>
          <li class="nav-item">
  <router-link class="nav-link icon-only" to="/results" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Results">
    <i class="bi bi-trophy-fill"></i>
  </router-link>
</li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/news" data-bs-toggle="tooltip" data-bs-placement="bottom" title="News">
              <i class="bi bi-newspaper"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/favorites" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Favorites">
              <i class="bi bi-heart-fill"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/teams" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Teams">
              <i class="bi bi-people-fill"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/players" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Players">
              <i class="bi bi-person-fill"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/transfers" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Transfers">
              <i class="bi bi-arrow-left-right"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/notifications" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifications">
              <i class="bi bi-bell-fill"></i>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link icon-only" to="/calendar" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calendar">
              <i class="bi bi-calendar-event-fill"></i>
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
          <li class="nav-item">
            <router-link class="nav-link" to="/">
              <i class="bi bi-house-fill me-1"></i> Home
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/spotlight">
              <i class="bi bi-camera-reels-fill me-1"></i> Spotlight
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/results">
              <i class="bi bi-trophy-fill me-1"></i> Results
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/news">
              <i class="bi bi-newspaper me-1"></i> News
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/favorites">
              <i class="bi bi-heart-fill me-1"></i> Favorites
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/teams">
              <i class="bi bi-people-fill me-1"></i> Teams
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/players">
              <i class="bi bi-person-fill me-1"></i> Players
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/transfers">
              <i class="bi bi-arrow-left-right me-1"></i> Transfers
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/notifications">
              <i class="bi bi-bell-fill me-1"></i> Notifications
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/calendar">
              <i class="bi bi-calendar-event-fill me-1"></i> Calendar
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/settings">
              <i class="bi bi-gear-fill me-1"></i> Settings
            </router-link>
          </li>
        </ul>

        <div class="d-flex my-2 my-lg-0">
          <router-link to="/login" class="btn btn-outline-success me-2">Login</router-link>
          <router-link to="/register" class="btn btn-success">Register</router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { onMounted, nextTick } from 'vue';
import * as bootstrap from 'bootstrap'; // Importo Toast (Tooltip) nga Bootstrap

// Funksion Placeholder per Logout (do të lidhet me backend më vonë)
const logout = () => {
  alert('Funksionaliteti i Logout do të implementohet më vonë!');
  // Logjika reale e logout do të vijë këtu
};

// Inicializo Tooltips pasi komponenti është montuar
onMounted(() => {
  nextTick(() => {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
});
</script>

<style scoped>
/* Stilet e ikonave të Bootstrap Icons janë të menaxhuara nga libri */
/* Vendosja vertikale e ikonave me tekstin */
.navbar-brand i,
.nav-link i {
    vertical-align: middle;
}

/* Stilim shtesë për lidhjet vetëm me ikona (opsionale) */
.nav-link.icon-only {
    font-size: 1.5rem; /* Bën ikonat pak më të mëdha */
    padding: 0.5rem 0.75rem; /* Rregullon padding */
    display: flex;
    justify-content: center;
    align-items: center;
    color: rgba(255, 255, 255, 0.75); /* Ngjyra e ikonave */
}

.nav-link.icon-only:hover {
    color: white;
}

/* Rregullon hapësirën rreth ikonave kur janë vetëm ikona */
.nav-link.icon-only i {
    margin-right: 0 !important;
}

/* Stilim per router-link active state */
.router-link-active {
  color: white !important; /* Ngjyra e bardhë për lidhjen aktive */
  font-weight: bold;
}
.router-link-active.icon-only {
  border-bottom: 2px solid var(--bs-primary); /* Vija poshtë ikonës aktive */
  padding-bottom: calc(0.5rem - 2px); /* Rregullon paddingun me border-in */
}

/* Personalizim i dropdown-it të autentifikimit nëse përdoret */
</style>