<template>
    <div class="notifications-page container my-5">
      <h1 class="text-center mb-5 text-primary fw-bold">Njoftimet Tua</h1>
  
      <div class="notifications-controls text-end mb-4">
        <button @click="markAllAsRead" class="btn btn-primary btn-sm">
          <i class="bi bi-check-circle-fill me-1"></i> Shëno të gjitha si të lexuara
        </button>
      </div>
  
      <div class="notifications-list">
        <div v-if="notifications.length === 0" class="alert alert-info text-center" role="alert">
          Nuk keni asnjë njoftim.
        </div>
        <div v-else class="list-group">
          <div v-for="notification in notifications" :key="notification.id"
               :class="['list-group-item', 'list-group-item-action', 'shadow-sm', 'rounded-lg', 'mb-3', 'notification-item', {'unread': !notification.read}]"
               @click="markAsRead(notification.id)">
            <div class="d-flex w-100 justify-content-between align-items-center">
              <h5 class="mb-1 fw-bold">{{ notification.title }}</h5>
              <small class="text-muted">{{ formatDateTime(notification.timestamp) }}</small>
            </div>
            <p class="mb-1 text-secondary">{{ notification.message }}</p>
            <small v-if="!notification.read" class="text-primary fw-bold">Pa lexuar</small>
            <small v-else class="text-success">Lexuar</small>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  // Të dhënat statike për njoftimet
  const notifications = ref([
    {
      id: 1,
      title: 'Ndeshja po fillon!',
      message: 'Ndeshja Real Madrid vs. Barcelona fillon pas 15 minutash.',
      timestamp: '2025-07-06T18:45:00Z',
      read: false
    },
    {
      id: 2,
      title: 'Lajm i ri: Superliga Evropiane',
      message: 'Artikull i ri mbi zhvillimet më të fundit rreth Superligës Evropiane.',
      timestamp: '2025-07-06T15:30:00Z',
      read: false
    },
    {
      id: 3,
      title: 'Rezultat i ndeshjes',
      message: 'Chelsea fitoi 2-1 kundër Manchester United.',
      timestamp: '2025-07-05T22:00:00Z',
      read: true
    },
    {
      id: 4,
      title: 'Koment i ri në transferimin e Bellingham',
      message: 'Një përdorues komentoi: "Ky ishte transferimi i shekullit!"',
      timestamp: '2025-07-05T10:15:00Z',
      read: true
    },
    {
      id: 5,
      title: 'Ekipi juaj i preferuar humbi',
      message: 'Bayern Munich humbi ndeshjen e fundit me rezultat 0-1.',
      timestamp: '2025-07-04T19:00:00Z',
      read: false
    },
  ]);
  
  // Funksioni për të shënuar një njoftim si të lexuar
  const markAsRead = (notificationId) => {
    const notification = notifications.value.find(n => n.id === notificationId);
    if (notification) {
      notification.read = true;
      // Në një aplikacion real, do të bëhej një kërkesë në backend për të ruajtur statusin.
    }
  };
  
  // Funksioni për të shënuar të gjitha njoftimet si të lexuara
  const markAllAsRead = () => {
    notifications.value.forEach(notification => {
      notification.read = true;
    });
    // Në një aplikacion real, do të bëhej një kërkesë në backend.
    alert('Të gjitha njoftimet u shënuan si të lexuara!');
  };
  
  // Funksion ndihmës për formatimin e datës dhe kohës
  const formatDateTime = (dateTimeString) => {
    if (!dateTimeString) return 'Data e panjohur';
    const date = new Date(dateTimeString);
    const options = {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      hour12: false // Formati 24-orësh
    };
    return date.toLocaleDateString('sq-AL', options) + ' ' + date.toLocaleTimeString('sq-AL', { hour: '2-digit', minute: '2-digit', hour12: false });
  };
  </script>
  
  <style scoped>
  .notifications-page {
    background-color: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
  }
  
  .notifications-controls {
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
  }
  
  .notification-item {
    background-color: white;
    border: 1px solid #dee2e6;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out, transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }
  
  .notification-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
  }
  
  .notification-item.unread {
    background-color: #e0f2f7; /* Një ngjyrë e lehtë blu për njoftimet e pa lexuara */
    border-left: 5px solid var(--bs-primary); /* Shirit primar në të majtë */
  }
  
  .notification-item.unread:hover {
      background-color: #d1ecf1; /* Ngjyrë pak më e theksuar në hover */
  }
  </style>