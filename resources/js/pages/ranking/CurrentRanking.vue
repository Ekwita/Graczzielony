<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PageLayout from '@/layouts/blog/PageLayout.vue';
import CountdownTimer from '@/components/CountdownTimer.vue';
import GameRankingTable from '@/components/ranking/GameRankingTable.vue';

defineProps({
  games: Array,
});
</script>

<template>

  <Head title="Aktualny ranking" />
  <PageLayout>
    <CountdownTimer />
    <div class="container">
      <h1 class="title">Ranking Gier</h1>

      <GameRankingTable :rows="games">
        <template #empty>
          W tym momencie nie zagłosowano na żadną grę.
          <Link :href="route('vote.index')"><strong>Możesz być pierwszy</strong></Link>
        </template>
      </GameRankingTable>
    </div>
  </PageLayout>
</template>

<style scoped>
.container {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

.title {
  text-align: center;
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 15px;
}
</style>
