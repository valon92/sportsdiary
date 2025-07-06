// resources/js/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import Home from '../Pages/Home.vue'; 
import Spotlight from '../Pages/Spotlight.vue';
import Results from '../Pages/Results.vue';
import News from '../Pages/News.vue';
import Favorites from '../Pages/Favorites.vue';
import Teams from '../Pages/Teams.vue';

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
  {
    path: '/news', // Rruga për faqen News
    name: 'news',
    component: News
  },
  {
    path: '/favorites', // Rruga për faqen Favorites
    name: 'favorites',
    component: Favorites
  },
  {
    path: '/teams', // Rruga për faqen Teams
    name: 'teams',
    component: Teams
  },
  // Këtu do të shtohen rrugë të tjera në të ardhmen
];

const router = createRouter({
  history: createWebHistory(), // Përdor historinë HTML5 API për URL të pastra
  routes,
});

export default router;