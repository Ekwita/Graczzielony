<script setup>
import AppNavigationBar from '@/components/AppNavigationBar.vue';
import PageLayout from '@/layouts/blog/PageLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Page Not Exists... yet" />

    <!-- <AppNavigationBar /> -->
    <PageLayout>
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
            <h1 class="text-4xl font-bold text-red-600">404 - Strona nie istnieje... jeszcze.</h1>
            <p class="text-gray-500 mt-2">Nie znaleziono strony, którą próbujesz odwiedzić.</p>
            <Link href="/" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg">
            Wróć na stronę główną
            </Link>
        </div>
    </PageLayout>
</template>

<style scoped></style>