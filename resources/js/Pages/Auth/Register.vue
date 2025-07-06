<template>
    <div class="auth-page mt-5 register-page d-flex align-items-center justify-content-center min-vh-100 py-5">
      <div class="register-container bg-white p-4 p-md-5 rounded shadow-lg">
        <h2 class="text-center mb-4 text-primary fw-bold">Regjistrohu</h2>
        <form @submit.prevent="handleRegister">
          <div class="mb-3">
            <label for="name" class="form-label">Emri i Përdoruesit:</label>
            <input type="text" class="form-control" id="name" v-model="form.name" required autocomplete="username">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" v-model="form.email" required autocomplete="email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Fjalëkalimi:</label>
            <input type="password" class="form-control" id="password" v-model="form.password" required autocomplete="new-password">
          </div>
          <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmo Fjalëkalimin:</label>
            <input type="password" class="form-control" id="password_confirmation" v-model="form.password_confirmation" required autocomplete="new-password">
          </div>
          <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary btn-lg">Regjistrohu</button>
          </div>
          <p class="text-center mt-3">
            Keni tashmë një llogari? <router-link to="/login" class="text-primary fw-bold">Hyr këtu</router-link>
          </p>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });
  
  const handleRegister = () => {
    // Këtu do të dërgoheshin të dhënat e regjistrimit në backend.
    // Për momentin, vetëm shfaqim në konsolë.
    console.log('Tentativa për Regjistrim:', form.value);
    alert('Regjistrimi u simulua! (Shih konsolën)');
    // Në një aplikacion real:
    // router.push('/login'); ose router.push('/dashboard');
  };
  </script>
  
  <style scoped>
  .auth-page {
    background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%); /* Gradient blu-vjollcë */
  }
  
  .register-container {
    max-width: 450px;
    width: 100%;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; /* Hijet e theksuara */
  }
  
  .form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); /* Hijet e fokusuara me ngjyrë primare */
  }
  </style>