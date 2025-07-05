<template>
  <Navbar />
  <main class="flex-grow-1">
    <div class="container my-5" style="min-height: 50vh;">
        <h1>Mirësevjen në Sports Diary!</h1>
        <p>Kjo është faqja jote kryesore.</p>
        <p>Përmbajtja këtu do të shtyjë footer-in poshtë. Nëse ka pak përmbajtje, footer-i do të qëndrojë në fund të ekranit.</p>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <p>Fundi i përmbajtjes.</p>
    </div>
  </main>
  <Footer />
</template>

<script setup>
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
</script>

<style scoped>
/* Asnjë stil specifik këtu nuk është i nevojshëm për sticky footer, Bootstrap e menaxhon */
</style>