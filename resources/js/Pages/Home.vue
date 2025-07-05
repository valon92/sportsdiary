<template>
  <div class="container my-5">
    <GenderFilter @update:gender="handleGenderUpdate" /> <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      <div class="col" v-for="sport in filteredSports" :key="sport.id">
        <SportCard
          :sportName="sport.sportName"
          :athleteName="sport.athleteName"
          :trophyName="sport.trophyName"
          :athletePhotoUrl="sport.athletePhotoUrl"
          :likes="sport.likes"
          :comments="sport.comments"
          :shares="sport.shares"
        />
      </div>
    </div>
    
    <div v-if="filteredSports.length === 0" class="text-center mt-5">
      <h3>Nuk u gjetën sporte për gjininë e zgjedhur.</h3>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'; // Fshij defineProps dhe watch
import SportCard from '../Components/SportCard.vue';
import GenderFilter from '../Components/GenderFilter.vue'; // Shto importin e GenderFilter

// Të dhëna statike për sportet
const allSports = ref([
  {
    id: 1,
    sportName: 'FOOTBALL',
    athleteName: 'Karim Benzema',
    trophyName: 'Ballon d\'Or 2022',
    athletePhotoUrl: 'https://images.rtl.fr/~c/720v480/rtl/www/1344426-karim-benzema-brandit-son-ballon-d-or-le-17-octobre-2022.jpg',
    likes: 1200,
    comments: 345,
    shares: 120,
    gender: 'men'
  },
  {
    id: 2,
    sportName: 'BASKETBALL',
    athleteName: 'LeBron James',
    trophyName: 'NBA Championship 2020',
    athletePhotoUrl: 'https://image-cdn.hypb.st/https%3A%2F%2Fhypebeast.com%2Fimage%2F2020%2F10%2Flebron-james-wins-fourth-nba-championship-fourth-finals-mvp-title-001.jpg?cbr=1&q=90&w=750&fit=max',
    likes: 980,
    comments: 210,
    shares: 80,
    gender: 'men'
  },
  {
    id: 3,
    sportName: 'TENNIS (Men)',
    athleteName: 'Novak Djokovic',
    trophyName: 'Wimbledon 2023',
    athletePhotoUrl: 'https://i.guim.co.uk/img/media/e4b4b2c12d4d9c7c2e3d3c8c7b8f9e6f0f0f0f0f/0_200_6000_3600/master/6000.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=5a4e0c7a8b4c7c7c7c7c7c7c7c7c7c7c',
    likes: 750,
    comments: 150,
    shares: 50,
    gender: 'men'
  },
  {
    id: 4,
    sportName: 'FOOTBALL (Women)',
    athleteName: 'Alexia Putellas',
    trophyName: 'Ballon d\'Or Féminin 2022',
    athletePhotoUrl: 'https://icdn.football-espana.net/wp-content/uploads/2022/10/putellas-ballon-dor.jpg',
    likes: 1100,
    comments: 300,
    shares: 100,
    gender: 'women'
  },
  {
    id: 5,
    sportName: 'BASKETBALL (Women)',
    athleteName: 'Breanna Stewart',
    trophyName: 'WNBA MVP 2023',
    athletePhotoUrl: 'https://cdn.cnn.com/cnnnext/dam/assets/230913134954-01-breanna-stewart-wnba-mvp-2023-restricted.jpg',
    likes: 600,
    comments: 180,
    shares: 60,
    gender: 'women'
  },
  {
    id: 6,
    sportName: 'TENNIS (Women)',
    athleteName: 'Iga Swiatek',
    trophyName: 'French Open 2023',
    athletePhotoUrl: 'https://sportingnews.com/us/tennis/news/iga-swiatek-french-open-2023-final-belarus-sabalenka/1o01c2n99e4b11f71a7d6e6a/image.jpg',
    likes: 700,
    comments: 140,
    shares: 45,
    gender: 'women'
  }
]);

// Variabël lokale për të mbajtur gjininë e zgjedhur
const selectedGender = ref('men'); // Vlera fillestare e gjinisë, tani menaxhohet nga Home.vue

// Funksioni që do të thirret kur GenderFilter dërgon eventin 'update:gender'
const handleGenderUpdate = (gender) => {
  selectedGender.value = gender;
  console.log('Home.vue: Gjinia e zgjedhur:', gender);
};


// `computed` property qe filtron sportet bazuar ne selectedGender.value
const filteredSports = computed(() => {
  return allSports.value.filter(sport => sport.gender === selectedGender.value);
});
</script>

<style scoped>
/* Stile shtesë nëse nevojiten, por Bootstrap menaxhon shumicën e layout-it të gridit */
</style>