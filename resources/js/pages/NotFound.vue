<script setup>
import AppNavigationBar from '@/layouts/app/AppNavigationBar.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Page Not Exists... yet" />

    <AppNavigationBar />

    <div class="flex flex-col items-center justify-center min-h-screen text-center">
        <h1 class="text-4xl font-bold text-red-600">404 - Strona nie istnieje... jeszcze.</h1>
        <p class="text-gray-500 mt-2">Nie znaleziono strony, którą próbujesz odwiedzić.</p>
        <Link href="/" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Wróć na stronę główną</Link>
    </div>
</template>

<style scoped></style>