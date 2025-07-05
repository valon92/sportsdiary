<template>
  <div class="d-flex justify-content-center my-4">
    <div class="btn-group" role="group" aria-label="Gender filter">
      <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" :checked="selectedGender === 'men'" @change="selectGender('men')">
      <label class="btn btn-outline-success" for="btnradio1">Men</label>

      <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" :checked="selectedGender === 'women'" @change="selectGender('women')">
      <label class="btn btn-outline-success" for="btnradio2">Women</label>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const selectedGender = ref('men'); // Vlera fillestare 'men'

// Deklarojmë ngjarjen që ky komponent do të dërgojë
const emit = defineEmits(['update:gender']);

const selectGender = (gender) => {
  selectedGender.value = gender;
  emit('update:gender', gender); // Dërgon vlerën e zgjedhur te prindi
};
</script>

<style scoped>
/* Asnjë stil specifik nuk është i nevojshëm, Bootstrap menaxhon pamjen e radio butonave */
</style>