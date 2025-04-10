<script setup>
import { Head } from '@inertiajs/vue3';
import PageLayout from '@/layouts/blog/PageLayout.vue';

const props = defineProps({
    ranking: Object,
});

const games = props.ranking.games;

const formatMonth = (dateStr) => {
    const date = new Date(dateStr);
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    return `${month}-${year}`;
};

</script>

<template>

    <Head title='Archiwum Top 10 gier' />
    <PageLayout>

        <div class="container">
            <h1 class="title">Top 10 gier za {{ formatMonth(ranking.month) }}</h1>

            <div class="table-container">
                <table class="game-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nazwa</th>
                            <th>Ocena</th>
                            <th>Głosy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(game, index) in games" :key="game.bgg_id" class="game-row">
                            <td class="center">{{ index + 1 }}</td>
                            <td class="game-info">
                                <a :href="game.hyperlink" target="_blank" class="game-link">
                                    <img :src="game.game_image" alt="Game image" class="game-image" />
                                    <span>{{ game.game_name }}</span>
                                </a>
                            </td>
                            <td class="center">{{ game.score }}</td>
                            <td class="center">{{ game.votes }}</td>
                        </tr>
                    </tbody>
                </table>
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
    margin-bottom: 15px;
}

.table-container {
    overflow-x: auto;
}

.game-table {
    width: 100%;
    border-collapse: collapse;
}

.game-table th,
.game-table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

.game-table th {
    background: #444;
    color: white;
    text-align: left;
}

.game-row:hover {
    background: #f5f5f5;
}

.center {
    text-align: center;
}

.game-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.game-link {
    display: flex;
    align-items: center;
    gap: 15px;
    text-decoration: none;
    color: inherit;
    width: 100%;
    height: 100%;
    padding: 10px 0;
}

.game-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.game-link:hover {
    text-decoration: underline;
}
</style>