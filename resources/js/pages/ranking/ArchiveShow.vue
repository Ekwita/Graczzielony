<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import PageLayout from '@/layouts/blog/PageLayout.vue';
import GameRankingTable from '@/components/ranking/GameRankingTable.vue';
import { formatMonth } from '@/composables/useMonthFormatter';

const props = defineProps({
    ranking: Object,
});

const rows = computed(() => props.ranking.games.map((game) => ({
    place: game.position,
    name: game.game_name,
    image: game.game_image,
    hyperlink: game.hyperlink,
    score: game.score,
    votes: game.votes,
    highlight: game.position <= 3,
})));
</script>

<template>

    <Head title='Archiwum Top 10 gier' />
    <PageLayout>

        <div class="container">
            <h1 class="title">Top 10 gier za {{ formatMonth(ranking.month) }}</h1>

            <GameRankingTable :rows="rows" />
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
