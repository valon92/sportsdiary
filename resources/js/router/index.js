// resources/js/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import Home from '../Pages/Home.vue';      // Importo komponentin Home
import Spotlight from '../Pages/Spotlight.vue'; // Këtë do ta krijojmë shpejt
import Results from '../Pages/Results.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/spotlight', // Rruga për faqen Spotlight
    name: 'spotlight',
    component: Spotlight
  },
  {
    path: '/results', // Rruga për faqen Results
    name: 'results',
    component: Results
  },
  // Këtu do të shtohen rrugë të tjera në të ardhmen
];

const router = createRouter({
  history: createWebHistory(), // Përdor historinë HTML5 API për URL të pastra
  routes,
});

export default router;