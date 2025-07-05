<script setup>
import Navbar from './Components/Navbar.vue';
import Footer from './Components/Footer.vue';
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <Navbar />

    <main class="flex-grow p-4">
      <h1 class="text-3xl font-bold text-center my-8">Mirë se vini në Sports Diary!</h1>
      <p class="text-center text-gray-700">Kjo është përmbajtja kryesore e aplikacionit tënd.</p>
    </main>

    <Footer />
  </div>
</template>

<style>
/* Stilet globale për aplikacionin (nëse nevojiten) */
</style>