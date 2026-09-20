<script setup>

import { ref, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";

const openMenu = ref(null);
const isMobileMenuOpen = ref(false);

const toggleMenu = (menu) => {
    openMenu.value = openMenu.value === menu ? null : menu;
};

const closeMenus = () => {
    openMenu.value = null;
};

const closeAll = () => {
    openMenu.value = null;
    isMobileMenuOpen.value = false;
};

onMounted(() => document.addEventListener('click', closeMenus));
onBeforeUnmount(() => document.removeEventListener('click', closeMenus));

</script>


<template>
    <nav class="navigation-bar">
        <div class="nav-bar-top">
            <button type="button" class="menu-toggle" @click.stop="isMobileMenuOpen = !isMobileMenuOpen"
                :aria-expanded="isMobileMenuOpen" aria-label="Menu">
                <span class="menu-toggle-bar"></span>
                <span class="menu-toggle-bar"></span>
                <span class="menu-toggle-bar"></span>
            </button>
        </div>
        <ul class="nav-list" :class="{ 'nav-list-open': isMobileMenuOpen }">
            <!-- Home -->
            <li class="nav-item">
                <Link :href="route('home')" class="nav-link" active-class="active" @click="closeAll">Strona główna</Link>
            </li>
            <!-- Ranking -->
            <li class="nav-item relative" @click.stop>
                <button type="button" class="nav-link" @click="toggleMenu('ranking')">Ranking</button>
                <ul v-if="openMenu === 'ranking'" class="dropdown-menu">
                    <li class="nav-item">
                        <Link :href="route('vote.index')" class="nav-link" active-class="active" @click="closeAll">
                            Wybierz grę miesiąca
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('ranking.index')" class="nav-link" active-class="active" @click="closeAll">
                            Aktualny ranking
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/ranking/archiwum" class="nav-link" active-class="active" @click="closeAll">
                            Archiwalne rankingi
                        </Link>
                    </li>
                </ul>
            </li>

            <!-- Blog -->
            <li class="nav-item relative" @click.stop>
                <button type="button" class="nav-link" @click="toggleMenu('blog')">Blog</button>
                <ul v-if="openMenu === 'blog'" class="dropdown-menu">
                    <li class="nav-item">
                        <Link href="/blog/recenzje" class="nav-link" active-class="active" @click="closeAll">Recenzje</Link>
                    </li>
                    <li class="nav-item">
                        <Link href="/blog/opinie" class="nav-link" active-class="active" @click="closeAll">Niepopularne opinie</Link>
                    </li>
                </ul>
            </li>

            <!-- About -->
            <li class="nav-item">
                <Link :href="route('about')" class="nav-link" active-class="active" @click="closeAll">O mnie</Link>
            </li>
        </ul>
    </nav>
</template>


<style scoped>
.navigation-bar {
    background: #333;
    padding: 10px;
}

.nav-bar-top {
    display: none;
    justify-content: flex-end;
}

.menu-toggle {
    background: transparent;
    border: none;
    padding: 8px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    cursor: pointer;
}

.menu-toggle-bar {
    display: block;
    width: 24px;
    height: 2px;
    background: white;
}

.nav-list {
    display: flex;
    flex-wrap: wrap;
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
    background: transparent;
    border: none;
    font-size: inherit;
    cursor: pointer;
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
    max-width: calc(100vw - 20px);
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

@media (max-width: 700px) {
    .nav-bar-top {
        display: flex;
    }

    .nav-list {
        display: none;
        flex-direction: column;
        margin-top: 10px;
    }

    .nav-list-open {
        display: flex;
    }

    .nav-item {
        margin-right: 0;
    }

    .dropdown-menu {
        position: static;
        box-shadow: none;
        background: #444;
        min-width: 0;
        max-width: none;
        margin-left: 10px;
    }

    .dropdown-menu .nav-link {
        color: white;
    }

    .dropdown-menu .nav-link:hover {
        background: #555;
    }
}
</style>
