<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand text-success fw-bold fs-3" href="#">
        <i class="bi bi-calendar-check-fill me-2"></i> Sports Diary
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-none d-lg-flex flex-grow-1 justify-content-center">
          <li class="nav-item">
            <a class="nav-link icon-only" aria-current="page" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Home">
              <i class="bi bi-house-fill"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Spotlight">
              <i class="bi bi-camera-reels-fill"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Results">
              <i class="bi bi-trophy-fill"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="News">
              <i class="bi bi-newspaper"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Favorites">
              <i class="bi bi-heart-fill"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Teams">
              <i class="bi bi-people-fill"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Players">
              <i class="bi bi-person-fill"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Transfers">
              <i class="bi bi-arrow-left-right"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifications">
              <i class="bi bi-bell-fill"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link icon-only" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calendar">
              <i class="bi bi-calendar-event-fill"></i>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">
              <i class="bi bi-house-fill me-1"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-camera-reels-fill me-1"></i> Spotlight
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-trophy-fill me-1"></i> Results
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-newspaper me-1"></i> News
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-heart-fill me-1"></i> Favorites
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-people-fill me-1"></i> Teams
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-person-fill me-1"></i> Players
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-arrow-left-right me-1"></i> Transfers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-bell-fill me-1"></i> Notifications
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-calendar-event-fill me-1"></i> Calendar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="bi bi-gear-fill me-1"></i> Settings
            </a>
          </li>
        </ul>

        <div class="d-flex my-2 my-lg-0">
          <a href="#" class="btn btn-outline-success me-2">Login</a>
          <a href="#" class="btn btn-success">Register</a>
          </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { onMounted, nextTick } from 'vue';
// Importo Toast (Tooltip) nga Bootstrap
import * as bootstrap from 'bootstrap';

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

/* Personalizim i dropdown-it të autentifikimit nëse përdoret */
/* .dropdown-menu {
    background-color: #343a40;
    border-color: #495057;
}

.dropdown-item {
    color: rgba(255, 255, 255, 0.75);
}

.dropdown-item:hover {
    background-color: #495057;
    color: white;
} */
</style>