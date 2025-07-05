// resources/js/app.js
import './bootstrap';
import { createApp } from 'vue';
import App from './app.vue';
import router from './router'; // Importo konfigurimin e router-it


// Importo JavaScript-in e Bootstrap-it
import 'bootstrap'; // ose import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const app = createApp(App);
app.use(router);
app.mount('#app');