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
                <Link href="/" class="nav-link" active-class="active">Home</Link>
            </li>   
            <!-- Ranking -->
            <li class="nav-item relative" @mouseenter="isRankingOpen = true" @mouseleave="isRankingOpen = false">
                <button class="nav-link">Ranking</button>
                <ul v-if="isRankingOpen" class="dropdown-menu">
                    <li class="nav-item">
                        <Link href="/vote" class="nav-link" active-class="active">Vote for Best Game</Link>
                    </li>
                    <li class="nav-item">
                        <Link href="#" class="nav-link" active-class="active">Current Voting Results</Link>
                    </li>
                    <li class="nav-item">
                        <Link href="#" class="nav-link" active-class="active">Previous Voting Results
                        </Link>
                    </li>
                </ul>
            </li>

            <!-- Blog -->
            <li class="nav-item relative" @mouseenter="isBlogOpen = true" @mouseleave="isBlogOpen = false">
                <button class="nav-link">Blog</button>
                <ul v-if="isBlogOpen" class="dropdown-menu">
                    <li class="nav-item">
                        <Link href="#" class="nav-link" active-class="active">Reviews</Link>
                    </li>
                    <li class="nav-item">
                        <Link href="#" class="nav-link" active-class="active">Unpopular Opinions</Link>
                    </li>
                </ul>
            </li>

            <!-- About -->
            <li class="nav-item">
                <Link href="/about" class="nav-link" active-class="active">About</Link>
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
