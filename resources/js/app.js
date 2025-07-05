// resources/js/app.js
import './bootstrap'; // Përfshin Bootstrap-in e Laravel-it (axios etj.)
import { createApp } from 'vue'; // Importon funksionin createApp nga Vue
import App from './app.vue'; // Importon komponentin tënd kryesor app.vue

// Krijon një instancë të aplikacionit Vue
const app = createApp(App);

// Monton aplikacionin Vue në elementin me id 'app'
app.mount('#app');