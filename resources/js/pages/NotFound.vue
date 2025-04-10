<script setup>
import PageLayout from '@/layouts/blog/PageLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Strona w budowie" />
    <PageLayout>
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
            <h1 class="error">404 - Strona &lpar;jeszcze&rpar; nie istnieje...</h1>
            <p class="info">Nie znaleziono strony, którą próbujesz odwiedzić.</p>
            <Link href="/" class="button">
            Wróć na stronę główną
            </Link>
        </div>
    </PageLayout>
</template>

<style scoped>
h1 {
    font-size: 48px;
    font: 300, sans-serif;
    font-weight: bold;
}

.info {
    font-size: 18px;
    margin-bottom: 20px;
}

.button {
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

.button:hover {
    background: #212529;
}
</style>