<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import PageLayout from '@/layouts/blog/PageLayout.vue';
import axios from 'axios';

const username = ref('');
const queries = ref(['', '', '']);
const games = ref([[], [], []]);
const selectedGames = ref([null, null, null]);
const highlightedIndex = ref([null, null, null]);
const isSearching = ref([false, false, false]);
let searchTimeouts = [null, null, null];

const fetchGames = (index) => {
    clearTimeout(searchTimeouts[index]);
    searchTimeouts[index] = setTimeout(async () => {
        const query = queries.value[index].trim();
        if (query.length < 3) {
            games.value[index] = [];
            return;
        }
        isSearching.value[index] = true;

        try {
            const response = await axios.get('/search', { params: { search: query, index } });
            if (response.data.games) {
                games.value[index] = response.data.games[index];
            }
        } catch (error) {
            console.error("Error fetching games:", error);
        } finally {
            isSearching.value[index] = false;
        }
    }, 1000);
};

const selectGame = (game, index) => {
    selectedGames.value[index] = game;
    queries.value[index] = game.name;
    games.value[index] = [];
};

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

const isFormValid = computed(() => username.value && selectedGames.value.every(game => game));

const form = useForm({
    username: '',
    votes: [],
});

const showSuccessModal = ref(false);

const submitForm = () => {
    if (!isFormValid.value) {
        alert('Wszystkie pola są wymagane!');
        return;
    }

    form.username = username.value;
    form.votes = selectedGames.value.map((game, idx) => ({
        id: game?.id ?? null,
        name: game?.name ?? '',
        points: 3 - idx,
        image: game?.image ?? '',
    }));

    form.post(route('vote.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccessModal.value = true;

            setTimeout(() => {
                router.visit(route('ranking.index'));
            }, 3000);
        },
        onError: (errors) => {
            console.error("Błąd formularza:", errors);
            const messages = Object.values(errors).flat();
            alert(messages.join('\n'));
        }
    });
};
</script>


<template>

    <Head title="Zagłosuj na najlepsze gry miesiąca" />
    <PageLayout>
        <div class="container">
            <h1 class="title">Oddaj głos na najlepsze gry miesiąca</h1>

            <form @submit.prevent="submitForm" class="form">
                <div class="form-group">
                    <label for="username">Nazwa użytkownika:</label>
                    <input id="username" type="text" v-model="username" required />
                </div>

                <div v-for="(query, index) in queries" :key="index" class="form-group">
                    <label :for="`game-${index}`">Gra za {{ 3 - index }} pkt:</label>
                    <div class="game-selection">
                        <img v-if="selectedGames[index]?.image" :src="selectedGames[index].image" alt="thumbnail"
                            class="selected-thumbnail" />
                        <input :id="`game-${index}`" type="text" v-model="queries[index]" placeholder="Wpisz nazwę gry"
                            @keydown="handleKeydown($event, index)" @input="fetchGames(index)" autocomplete="off" />
                    </div>

                    <ul v-if="games[index].length" class="dropdown">
                        <li v-for="(game, i) in games[index]" :key="game.id"
                            :class="{ highlighted: i === highlightedIndex[index] }" @click="selectGame(game, index)">
                            <img v-if="game.image" :src="game.image" alt="thumbnail" class="thumbnail" />
                            <span>{{ game.name }} ({{ game.year }})</span>
                        </li>
                    </ul>
                </div>

                <button type="submit" class="btn-submit">Oddaj głos</button>
            </form>
        </div>

        <transition name="fade">
            <div v-if="showSuccessModal" class="modal-overlay">
                <div class="modal-content">
                    <div class="checkmark">&#10003;</div>
                    <p>Głos został oddany!</p>
                </div>
            </div>
        </transition>
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

.form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    width: 100%;
}

label {
    font-weight: bold;
    margin-bottom: 8px;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ccc;
    transition: border 0.2s;
    box-sizing: border-box;
}

input[type="text"]:focus {
    border-color: #007bff;
    outline: none;
}

.btn-submit {
    padding: 12px;
    font-size: 16px;
    background: #343a40;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transition: background 0.3s ease;
}

.btn-submit:hover {
    background: #212529;
}

.dropdown {
    list-style: none;
    padding: 0;
    margin-top: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background: white;
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
}

.dropdown li {
    display: flex;
    align-items: center;
    padding: 10px;
    cursor: pointer;
    transition: background 0.2s;
}

.dropdown li:hover,
.dropdown li.highlighted {
    background: #f5f5f5;
}

.thumbnail {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 5px;
    margin-right: 10px;
}

.game-selection {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
}

.selected-thumbnail {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 5px;
}


/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-content {
    background: white;
    padding: 30px 50px;
    border-radius: 10px;
    text-align: center;
    animation: pop-in 0.3s ease-out;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.checkmark {
    font-size: 48px;
    color: green;
    margin-bottom: 10px;
    animation: bounce 0.6s;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@keyframes pop-in {
    from {
        transform: scale(0.8);
        opacity: 0;
    }

    to {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes bounce {
    0% {
        transform: scale(0.5);
    }

    70% {
        transform: scale(1.2);
    }

    100% {
        transform: scale(1);
    }
}
</style>