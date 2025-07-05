<template>
  <Navbar />
  
  <GenderFilter />

  <Footer />

</template>

<script setup>
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
import GenderFilter from './Components/GenderFilter.vue';
</script>

<style scoped>
/* Asnjë stil specifik këtu nuk është i nevojshëm për sticky footer, Bootstrap e menaxhon */
</style>