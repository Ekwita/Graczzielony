<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import AppNavigationBar from '@/components/AppNavigationBar.vue';
</script>

<template>
    <div class="layout-wrapper">
        <AppNavigationBar />

        <main class="layout-main">
            <slot />
        </main>

        <AppFooter />
    </div>
</template>

<style scoped>
.layout-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.layout-main {
    flex: 1;
}
</style>
