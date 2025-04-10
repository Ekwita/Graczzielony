<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PageLayout from '@/layouts/blog/PageLayout.vue';
</script>

<template>

    <Head title="Strona główna" />

    <PageLayout>
        <div class="container">
            <h1>Hola wędrowcze!</h1>
            <p>
                Cieszę się, że zawitałeś w moje skromne progi. <strong>Gracz Zielony</strong> to mój mały projekt
                aplikacji internetowej poświęconej grom planszowym. Na ten moment ma dwa cele:
            </p>
            <ul>
                <li>Być moim portfolio pokazującym umiejętności tworzenia aplikacji webowych z użyciem języków PHP oraz
                    JavaScript.</li>
                <li>W przyszłości być rozbudowywanym o nowe funkcjonalności i, być może, stać się pełnoprawną witryną
                    internetową.</li>
            </ul>
            <p>
                Póki co w zakładce
                <Link :href="route('about')"><strong>"O mnie"</strong></Link>możesz znaleźć linki do mojego repozytorium
                na
                GitHubie,
                a w zakładce
                <Link :href="route('vote.index')"><strong>"Ranking"</strong></Link> oddać głos na swoje trzy
                ulubione gry miesiąca. Z
                czasem pojawią się nowe elementy.
            </p>
            <p class="signature">Miłego zwiedzania,<br>Wojciech Gałek</p>
        </div>
    </PageLayout>
</template>

<style scoped>
.container {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

h1 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 16px;
}

ul {
    list-style-type: disc;
    padding-left: 20px;
    margin-top: 10px;
}

.signature {
    margin-top: 20px;
    font-weight: bold;
}
</style>