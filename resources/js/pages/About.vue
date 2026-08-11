<script setup lang="ts">
import PageLayout from '@/layouts/blog/PageLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

  <Head title="O mnie" />
  <PageLayout>
    <div class="about-container">
      <!-- Photo -->
      <div class="profile-picture">
        <img src="img/photo.jpg" alt="Profile Picture" class="profile-img" />
      </div>

      <!-- Description -->
      <div class="about-description">
        <p>
          Jestem absolwentem Uniwersytetu Kardynała Stefana Wyszyńskiego
          w Warszawie na kierunku „kulturoznawstwo”, gdzie byłem także członkiem
          zarządu teatru akademickiego.
        </p>


        <p>
          W 2025 roku stałem się członkiem zespołu Software House'u -
          <a href="https://init.biz/pl" target="_blank" rel="noopener noreferrer" class="company-link">
            Init.biz
          </a>
          - z siedzibą w Staszowie. Dzięki temu mam przyjemność zdobywać tam swoje pierwsze komercyjne doświadczenie,
          szlifując swoje umiejętności jako backend junior developer, pracując przy takich projektach jak:
          <a href="https://schoolofwok.co.uk/" target="_blank" rel="noopener noreferrer" class="project-link">
            School of Wok
          </a>,
          <a href="https://lyfeguard.com/" target="_blank" rel="noopener noreferrer" class="project-link">
            Lyfeguard
          </a>
          czy
          <a href="https://slotgods.com/" target="_blank" rel="noopener noreferrer" class="project-link">
            SlotGods
          </a>.
        </p>

        <p>
          Ponadto cały czas skupiam się na doskonaleniu swoich umiejętności w języku PHP,
          korzystając głównie z frameworku Laravel.
        </p>
        <p>
          Poniżej znajdują się linki do repozytoriów z moimi projektami.
        </p>
      </div>

      <!-- Repository -->
      <div class="repo-tiles">
        <div class="repo-tile">
          <a href="https://github.com/Ekwita/BoardGames" target="_blank" rel="noopener noreferrer">
            <span>Aplikacja obsługująca grę planszową</span>
          </a>
        </div>

        <div class="repo-tile">
          <a href="https://github.com/Ekwita/shop-wisiadla" target="_blank" rel="noopener noreferrer">
            <span>Projekt koszyka sklepowego</span>
          </a>
        </div>

        <div class="repo-tile">
          <a href="https://github.com/Ekwita/boardgames-ranking/tree/develop" target="_blank" rel="noopener noreferrer">
            <span>Ranking gier planszowych - backend</span>
          </a>
        </div>
      </div>
    </div>
  </PageLayout>
</template>

<style scoped>
.about-container {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 32px;
}

.profile-picture {
  display: flex;
  justify-content: center;
  margin-bottom: 24px;
}

.profile-img {
  width: 256px;
  height: 256px;
  border-radius: 50%;
  border: 4px solid #e0e0e0;
}

.about-description {
  text-align: center;
  margin-bottom: 24px;
}

.about-description p {
  font-size: 1.125rem;
}

.repo-tiles {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 24px;
}

.repo-tile {
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  border: 1px solid #e0e0e0;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.repo-tile a {
  display: block;
  width: 100%;
  height: 100%;
  background-color: #f0f0f0;
  color: #333;
  text-align: center;
  line-height: 128px;
  text-decoration: none;
}

.repo-tile a:hover {
  background-color: #e0e0e0;
  transform: scale(1.05);
}

.company-link {
  font-weight: 600;
  text-decoration: none;
  transition: color 0.2s ease;
}

.company-link:hover {
  text-decoration: underline;
}

.about-description p {
  margin-bottom: 1rem;
}

.about-description p:last-child {
  margin-bottom: 0;
}
</style>