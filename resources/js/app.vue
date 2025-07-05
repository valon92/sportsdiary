<template>
  <Navbar />
  <main class="flex-grow-1">
    <router-view></router-view>
  </main>
  <Footer />
</template>

<script setup>
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
// Nuk kemi më nevojë të importojmë Home.vue apo GenderFilter këtu, pasi ato do të menaxhohen nga router-i ose nga faqet specifike.
// import Home from './Pages/Home.vue';
// import GenderFilter from './Components/GenderFilter.vue';

// Nuk kemi më nevojë për currentGender apo handleGenderUpdate këtu,
// pasi filtri i gjinisë do të shfaqet në faqen Home.vue dhe do të menaxhojë logjikën e saj.
// import { ref } from 'vue';
// const currentGender = ref('men');
// const handleGenderUpdate = (gender) => {
//   currentGender.value = gender;
//   console.log('app.vue: Gjinia e zgjedhur:', gender);
// };
</script>

<style scoped>
/* Asnjë stil specifik këtu nuk është i nevojshëm */
</style>