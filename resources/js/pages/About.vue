<script setup lang="ts">
import AppNavigationBar from '@/layouts/app/AppNavigationBar.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="About Me" />

  <AppNavigationBar />  
    <div class="about-container">
      <!-- Photo -->
      <div class="profile-picture">
        <img 
          src="#" 
          alt="Profile Picture" 
          class="profile-img"
        /> 
      </div>

      <!-- Description -->
      <div class="about-description">
        <p>
          I am a graduate of Cardinal Stefan Wyszyński University in Warsaw, where I studied "Cultural Studies" and was also a member of the executive board of the academic theater.
          Currently, I work in a transport company. 
          I am focusing on improving my skills in PHP, primarily using the Laravel framework, and recently also in JavaScript, especially Vue.js. 
          Currently, I am self-teaching by exploring the official documentation of the aforementioned programming languages and the frameworks I use.
        </p>
      </div>

      <!-- Repository -->
      <div class="repo-tiles">
        <div class="repo-tile">
          <a href="#" target="_blank">
            <span>GitHub Repo 1</span>
          </a>
        </div>
        <div class="repo-tile">
          <a href="#" target="_blank">
            <span>GitHub Repo 2</span>
          </a>
        </div>
        <div class="repo-tile">
          <a href="#" target="_blank">
            <span>GitHub Repo 3</span>
          </a>
        </div>
      </div>
    </div>
</template>

<style scoped>
.about-container {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 32px;
}

/* Photo */
.profile-picture {
  display: flex;
  justify-content: center;
  margin-bottom: 24px;
}

.profile-img {
  width: 128px;
  height: 128px;
  border-radius: 50%;
  border: 4px solid #e0e0e0; /* Szara ramka */
}

/* Description */
.about-description {
  text-align: center;
  margin-bottom: 24px;
}

.about-description p {
  font-size: 1.125rem;
}

/* Repository */
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
  line-height: 128px; /* Ustalamy wysokość, by tekst był wyśrodkowany */
  text-decoration: none;
}

.repo-tile a:hover {
  background-color: #e0e0e0;
  transform: scale(1.05);
}

</style>