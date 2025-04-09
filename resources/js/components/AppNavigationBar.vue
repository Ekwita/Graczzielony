<script setup>

import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
const isRankingOpen = ref(false);
const isBlogOpen = ref(false);

</script>


<template>
    <nav class="navigation-bar">
        <ul class="nav-list">
            <!-- Home -->
            <li class="nav-item">
                <Link :href="route('home')" class="nav-link" active-class="active">Strona główna</Link>
            </li>
            <!-- Ranking -->
            <li class="nav-item relative" @mouseenter="isRankingOpen = true" @mouseleave="isRankingOpen = false">
                <button class="nav-link">Ranking</button>
                <ul v-if="isRankingOpen" class="dropdown-menu">
                    <li class="nav-item">
                        <Link :href="route('vote.index')" class="nav-link" active-class="active">Wybierz grę miesiąca
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('ranking.index')" class="nav-link" active-class="active">Aktualny ranking
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/ranking-archiwum" class="nav-link" active-class="active">Archiwalne rankingi
                        </Link>
                    </li>
                </ul>
            </li>

            <!-- Blog -->
            <li class="nav-item relative" @mouseenter="isBlogOpen = true" @mouseleave="isBlogOpen = false">
                <button class="nav-link">Blog</button>
                <ul v-if="isBlogOpen" class="dropdown-menu">
                    <li class="nav-item">
                        <Link href="/blog/recenzje" class="nav-link" active-class="active">Recenzje</Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/blog/opinie" class="nav-link" active-class="active">Niepopularne opinie</Link>
                    </li>
                </ul>
            </li>

            <!-- About -->
            <li class="nav-item">
                <Link :href="route('about')" class="nav-link" active-class="active">O mnie</Link>
            </li>
        </ul>
    </nav>
</template>


<style scoped>
.navigation-bar {
    background: #333;
    padding: 10px;
}

.nav-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    position: relative;
    margin-right: 20px;
}

.nav-link {
    color: white;
    text-decoration: none;
    padding: 10px;
    display: block;
}

.nav-link:hover {
    background: #555;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    border-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    list-style: none;
    padding: 5px 0;
    min-width: 200px;
    z-index: 100;
}

.dropdown-menu .nav-item {
    margin: 0;
}

.dropdown-menu .nav-link {
    color: black;
    padding: 10px;
    white-space: nowrap;
}

.dropdown-menu .nav-link:hover {
    background: #f0f0f0;
}
</style>
