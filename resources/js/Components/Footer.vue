<template>
  <footer class="bg-gray-900 p-8 mt-auto">
    <div class="container mx-auto text-center text-gray-400">
      <p>&copy; {{ currentYear }} Sports Diary. Të gjitha të drejtat të rezervuara.</p>
      <div class="flex justify-center space-x-6 mt-4">
        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Privacy Policy</a>
        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Terms of Service</a>
        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Contact Us</a>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue';

const currentYear = ref(new Date().getFullYear());
</script>

<style scoped>
/* Stilet specifike për këtë komponent (opsionale) */
</style>