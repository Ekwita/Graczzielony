<script setup>
defineProps({
    rows: {
        type: Array,
        required: true,
    },
});
</script>

<template>
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
            <tbody v-if="rows.length">
                <tr v-for="row in rows" :key="row.hyperlink" class="game-row" :class="{ 'top-ranking': row.highlight }">
                    <td class="center">{{ row.place }}</td>
                    <td class="game-info">
                        <a :href="row.hyperlink" target="_blank" class="game-link">
                            <img :src="row.image" alt="Game image" class="game-image" />
                            <span>{{ row.name }}</span>
                        </a>
                    </td>
                    <td class="center">{{ row.score }}</td>
                    <td class="center">{{ row.votes }}</td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4" class="center">
                        <slot name="empty" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
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

.top-ranking {
    background-color: #d4edda;
    color: #155724;
    font-weight: bold;
}

.game-row:hover {
    background: #f5f5f5;
    color: #212529;
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

@media (max-width: 480px) {
    .game-table th,
    .game-table td {
        padding: 8px;
        font-size: 14px;
    }

    .game-info {
        gap: 8px;
    }

    .game-link {
        gap: 8px;
    }

    .game-image {
        width: 48px;
        height: 48px;
    }
}
</style>
