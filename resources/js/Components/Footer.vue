<template>
  <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
    <div class="container text-center text-md-start">
      <div class="row text-center text-md-start">

        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 fw-bold text-success">
            Sports Diary
          </h5>
          <p>
            Platforma jote e dedikuar për ndjekjen e rezultateve sportive, lajmeve, dhe kalendarit të eventeve. Mbani gjithçka në një vend!
          </p>
        </div>

        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 fw-bold text-success">
            Platforma
          </h5>
          <p><a href="#" class="text-white text-decoration-none">Home</a></p>
          <p><a href="#" class="text-white text-decoration-none">Spotlight</a></p>
          <p><a href="#" class="text-white text-decoration-none">Results</a></p>
          <p><a href="#" class="text-white text-decoration-none">News</a></p>
          <p><a href="#" class="text-white text-decoration-none">Favorites</a></p>
        </div>

        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 fw-bold text-success">
            Ndihmë & Info
          </h5>
          <p><a href="#" class="text-white text-decoration-none">Help</a></p>
          <p><a href="#" class="text-white text-decoration-none">Tell a Friend</a></p>
          <p><a href="#" class="text-white text-decoration-none">Contact Us</a></p>
          <p><a href="#" class="text-white text-decoration-none">Settings</a></p>
          <p><a href="#" class="text-white text-decoration-none">Notifications</a></p>
        </div>

        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 fw-bold text-success">
            Politikat
          </h5>
          <p><a href="#" class="text-white text-decoration-none">Privacy Policy</a></p>
          <p><a href="#" class="text-white text-decoration-none">Terms of Service</a></p>
          <p><a href="#" class="text-white text-decoration-none">Cookies Policy</a></p>
          <p><a href="#" class="text-white text-decoration-none">Vibration & Alerts</a></p>
        </div>
      </div>

      <hr class="mb-4">

      <div class="row align-items-center">
        <div class="col-md-7 col-lg-8">
          <p class="text-center text-md-start">
            &copy; {{ currentYear }} Sports Diary. Të gjitha të drejtat të rezervuara.
          </p>
        </div>
        <div class="col-md-5 col-lg-4">
          <div class="text-center text-md-end">
            <ul class="list-unstyled list-inline">
              <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-facebook fs-4"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-twitter fs-4"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-instagram fs-4"></i></a>
              </li>
              <li class="list-inline-item">
                <a href="#" class="text-white"><i class="bi bi-linkedin fs-4"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue';

const currentYear = ref(new Date().getFullYear());
</script>

<style scoped>
/* Bootstrap menaxhon stilin, por nëse ke nevojë për stile shtesë specifike për këtë komponent */
a {
    transition: color 0.3s ease-in-out; /* Efekt i butë në hover */
}

a:hover {
    color: #28a745 !important; /* Ngjyra e gjelbër e Bootstrap 'success' */
}

.list-inline-item {
    margin-right: 1.5rem; /* Hapësirë mes ikonave sociale */
}

.list-inline-item:last-child {
    margin-right: 0;
}
</style>