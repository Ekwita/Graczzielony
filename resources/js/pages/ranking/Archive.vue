<script setup>
import { Head, router } from '@inertiajs/vue3';
import PageLayout from '@/layouts/blog/PageLayout.vue';

const props = defineProps({
    rankings: Object,
});

const rankingsList = props.rankings;

const formatMonth = (dateStr) => {
    const date = new Date(dateStr);
    const formatted = new Intl.DateTimeFormat('pl-PL', { month: 'long', year: 'numeric' }).format(date);
    return formatted.charAt(0).toUpperCase() + formatted.slice(1);
};

const goToRanking = (id) => {
    router.visit(`/ranking/archiwum/${id}`);
};
</script>

<template>

    <Head title="Archiwalne rankingi" />
    <PageLayout>
        <div class="container">
            <h1 class="title">Archiwalne rankingi</h1>

            <div class="tiles-container">
                <div v-for="ranking in rankingsList" :key="ranking.id" class="tile" @click="goToRanking(ranking.id)">
                    <div class="tile-header">{{ formatMonth(ranking.month) }}</div>
                    <div class="tile-content">
                        <div class="winner-title">Zwycięzca: "{{ ranking.winner_name }}"</div>
                        <div class="winner-image">
                            <img :src="ranking.winner_image" alt="Game image" />
                        </div>
                    </div>
                </div>
            </div>
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
    margin-bottom: 25px;
}

.tiles-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.tile {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    width: 240px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    text-align: center;
}

.tile:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    background-color: #e9ecef;
}

.tile-header {
    font-size: 16px;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 10px;
}

.winner-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #212529;
}

.winner-image img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.winner-image img:hover {
    transform: scale(1.03);
}
</style>
