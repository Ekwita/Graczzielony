<script setup>
import { ref, watch, computed } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import AppNavigationBar from '@/layouts/app/AppNavigationBar.vue';

const page = usePage();
const username = ref('');
const email = ref('');
const queries = ref(['', '', '']);
const games = ref([[], [], []]);
const selectedGames = ref([null, null, null]);
const highlightedIndex = ref([null, null, null]);
const isSearching = ref([false, false, false]);

// Reagowanie na zmiany w danych z backendu
watch(() => page.props.games, (newGames) => {
    if (newGames) {
        queries.value.forEach((_, index) => {
            games.value[index] = newGames[index] || [];
        });
    }
}, { deep: true });

// Pobieranie gier z backendu
const fetchGames = async (index) => {
    const query = queries.value[index].trim();
    if (query.length < 3) {
        games.value[index] = [];
        return;
    }
    isSearching.value[index] = true;

    router.get('/search', { search: query, index }, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => isSearching.value[index] = false,
    });
};

// Wybór gry
const selectGame = (game, index) => {
    selectedGames.value[index] = game;
    queries.value[index] = game.name;
    games.value[index] = [];
};

// Obsługa nawigacji klawiaturą
const handleKeydown = (event, index) => {
    const items = games.value[index];
    if (!items.length) return;
    const current = highlightedIndex.value[index];

    if (event.key === 'ArrowDown') {
        highlightedIndex.value[index] = current === null || current === items.length - 1 ? 0 : current + 1;
    } else if (event.key === 'ArrowUp') {
        highlightedIndex.value[index] = current === null || current === 0 ? items.length - 1 : current - 1;
    } else if (event.key === 'Enter' && current !== null) {
        selectGame(items[current], index);
    }
};

// Walidacja formularza
const isFormValid = computed(() => username.value && email.value && selectedGames.value.every(game => game));

// Wysłanie głosu
const submitForm = () => {
    if (!isFormValid.value) {
        alert('Wszystkie pola są wymagane!');
        return;
    }

    const voteData = selectedGames.value.map((game, index) => ({
        id: game.id,
        name: game.name,
        points: 3 - index,
        image: game.image,
    }));

    router.post('/vote', { username: username.value, email: email.value, votes: voteData });
};
</script>

<template>

    <Head title="Vote for Best Game" />
    <AppNavigationBar />

    <div class="container">
        <div class="content">
            <h1 class="title">Vote for your favorite board game</h1>
            <form @submit.prevent="submitForm" class="form">
                <div class="form-group">
                    <label for="username">User name:</label>
                    <input id="username" type="text" v-model="username" required />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" type="email" v-model="email" required />
                </div>

                <div v-for="(query, index) in queries" :key="index" class="form-group">
                    <label :for="`game-${index}`">Select game for ({{ 3 - index }} points):</label>
                    <input :id="`game-${index}`" type="text" v-model="queries[index]" placeholder="Wpisz nazwę gry"
                        @keydown="handleKeydown($event, index)" @input="fetchGames(index)" autocomplete="off" />

                    <ul v-if="games[index].length" class="dropdown">
                        <li v-for="(game, i) in games[index]" :key="game.id"
                            :class="{ highlighted: i === highlightedIndex[index] }" @click="selectGame(game, index)">
                            <img v-if="game.image" :src="game.image" alt="thumbnail" class="thumbnail" />
                            {{ game.name }} ({{ game.year }})
                        </li>
                    </ul>
                </div>

                <button type="submit" class="btn-submit">Vote</button>
            </form>
        </div>
    </div>
</template>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: #f8f9fa;
}

.content {
    width: 100%;
    max-width: 800px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    display: inline-block;
}

.title {
    font-size: 2.5em;
    font-weight: bold;
    margin-bottom: 30px;
}

.form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 10px;
}

input[type="text"],
input[type="email"] {
    width: 100%;
    padding: 10px;
    font-size: 1em;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.btn-submit {
    padding: 10px;
    font-size: 1.2em;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.dropdown {
    list-style-type: none;
    padding: 0;
    margin: 10px 0 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-height: 200px;
    overflow-y: auto;
    background: white;
}
</style>
