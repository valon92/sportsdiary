// resources/js/app.js
import './bootstrap';
import { createApp } from 'vue';
import App from './app.vue';

// Importo JavaScript-in e Bootstrap-it
import 'bootstrap'; // ose import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const app = createApp(App);
app.mount('#app');