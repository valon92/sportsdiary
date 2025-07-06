<template>
    <div class="auth-page login-page d-flex align-items-center justify-content-center min-vh-100 py-5">
      <div class="login-container bg-white p-4 p-md-5 rounded shadow-lg">
        <h2 class="text-center mb-4 text-primary fw-bold">Hyr në Llogari</h2>
        <form @submit.prevent="handleLogin">
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" v-model="form.email" required autocomplete="email">
          </div>
          <div class="mb-4">
            <label for="password" class="form-label">Fjalëkalimi:</label>
            <input type="password" class="form-control" id="password" v-model="form.password" required autocomplete="current-password">
          </div>
          <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary btn-lg">Hyr</button>
          </div>
          <p class="text-center mt-3">
            Nuk keni një llogari? <router-link to="/register" class="text-primary fw-bold">Regjistrohuni këtu</router-link>
          </p>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const form = ref({
    email: '',
    password: '',
  });
  
  const handleLogin = () => {
    // Këtu do të dërgoheshin të dhënat e login-it në backend.
    // Për momentin, vetëm shfaqim në konsolë.
    console.log('Tentativa për Hyrje:', form.value);
    alert('Hyrja u simulua! (Shih konsolën)');
    // Në një aplikacion real:
    // router.push('/dashboard'); ose router.push('/');
  };
  </script>
  
  <style scoped>
  .auth-page {
    background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%); /* Gradient blu-vjollcë */
  }
  
  .login-container {
    max-width: 450px;
    width: 100%;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; /* Hijet e theksuara */
  }
  
  .form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); /* Hijet e fokusuara me ngjyrë primare */
  }
  </style>