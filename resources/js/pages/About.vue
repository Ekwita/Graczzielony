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
          Jestem absolwentem Uniwersytetu Kardynała Stefana Wyszyńskiego w Warszawie na kierunku „kulturoznawstwo”,
          gdzie
          byłem także członkiem zarządu teatru akademickiego. Aktualnie pracuję w firmie transportowej.

          Obecnie skupiam się na doskonaleniu swoich umiejętności w języku PHP, korzystając głównie z frameworku
          Laravel,
          a ostatnio także w JavaScript, w szczególności Vue.js. Aktualnie uczę się samodzielnie, zapoznając się z
          oficjalną dokumentacją ww. języków programowania oraz wykorzystywanych przeze mnie frameworków.

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

  </PageLayout>
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
  border: 4px solid #e0e0e0;
  /* Szara ramka */
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
  line-height: 128px;
  text-decoration: none;
}

.repo-tile a:hover {
  background-color: #e0e0e0;
  transform: scale(1.05);
}
</style>