<template>
  <Navbar />
  <GenderFilter @update:gender="handleGenderUpdate" />
  <main class="flex-grow-1">
    <Home :gender="currentGender" />
  </main>
  <Footer />
</template>

<script setup>
import { ref } from 'vue';
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
import GenderFilter from './Components/GenderFilter.vue';
import Home from './Pages/Home.vue'; // Importo komponentin Home

const currentGender = ref('men'); // Vlera fillestare e gjinisë

const handleGenderUpdate = (gender) => {
  currentGender.value = gender;
  console.log('app.vue: Gjinia e zgjedhur:', gender);
};
</script>

<style scoped>
/* Asnjë stil specifik këtu nuk është i nevojshëm */
</style>