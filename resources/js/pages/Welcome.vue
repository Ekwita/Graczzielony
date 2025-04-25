<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PageLayout from '@/layouts/blog/PageLayout.vue';
import { ref, onMounted, onUnmounted } from 'vue';

import CountdownTimer from '@/components/CountdownTimer.vue';

const props = defineProps<{
    recentWinners: {
        month: string;
        winner_name: string;
        winner_image: string;
    }[];
}>();

const recentWinners = props.recentWinners;


const currentIndex = ref(0);
let interval: number;

onMounted(() => {
    interval = setInterval(() => {
        currentIndex.value = (currentIndex.value + 1) % props.recentWinners.length;
    }, 6000);
});

const formatMonth = (strDate: string): string => {
    const date = new Date(strDate);
    const formatted = new Intl.DateTimeFormat('pl-PL', { month: 'long', year: 'numeric' }).format(date);
    return formatted;
};

onUnmounted(() => {
    clearInterval(interval);
});
</script>

<template>

    <Head title="Strona główna" />

    <PageLayout>
        <div class="main-layout">
            <div class="left-column">
                <h1>Hola wędrowcze!</h1>
                <p>
                    Cieszę się, że zawitałeś w moje skromne progi. <strong>Gracz Zielony</strong> to mój mały projekt
                    aplikacji internetowej poświęconej grom planszowym. Na ten moment ma dwa cele:
                </p>
                <ul>
                    <li>1. Być moim portfolio pokazującym umiejętności tworzenia aplikacji webowych z użyciem języków PHP
                        oraz JavaScript.</li>
                    <li>2. W przyszłości być rozbudowywanym o nowe funkcjonalności i, być może, stać się pełnoprawną
                        witryną internetową.</li>
                </ul>
                <p>
                    Póki co w zakładce
                    <Link :href="route('about')"><strong>"O mnie"</strong></Link> możesz znaleźć linki do mojego
                    repozytorium
                    na GitHubie, a w zakładce
                    <Link :href="route('vote.index')"><strong>"Ranking"</strong></Link> oddać głos na swoje trzy
                    ulubione gry miesiąca. Z czasem pojawią się nowe elementy.
                </p>
                <p class="signature">Miłego zwiedzania,<br>Wojciech Gałek</p>
                <CountdownTimer />
            </div>

            <div class="right-column">
                <div class="carousel" v-if="recentWinners.length">
                    <div class="carousel-item" :key="currentIndex">
                        <a :href="recentWinners[currentIndex].games[0].hyperlink" target="_blank">
                            <div class="carousel-month">Najlepsza gra: {{
                                formatMonth(recentWinners[currentIndex].month) }}</div>
                            <div class="carousel-name">{{ recentWinners[currentIndex].winner_name }}</div>
                            <img :src="recentWinners[currentIndex].winner_image" alt="Zwycięzca"
                                class="carousel-image" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </PageLayout>
</template>

<style scoped>
h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

.main-layout {
    display: flex;
    flex-direction: row;
    gap: 20px;
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
}

.left-column {
    flex: 3;
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

.right-column {
    display: grid;
    justify-content: center;
}

.carousel {
    width: 100%;
    max-width: 300px;
    background: #f5f5f5;
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.carousel-item {
    animation: fade 1s ease-in-out;
}

.carousel-month {
    font-weight: bold;
    margin-bottom: 8px;
}

.carousel-name {
    margin-bottom: 10px;
}

.carousel-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.signature {
    margin-top: 20px;
    font-weight: bold;
}

@keyframes fade {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>
