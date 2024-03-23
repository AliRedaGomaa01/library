<script setup>
import AppHeader from '@/Layouts/Partials/AppHeader.vue';
import AppFooter from '@/Layouts/Partials/AppFooter.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
let isEn = computed(() => usePage().props.lang == 'en');

</script>

<template>
    <div class="grid min-h-[100vh]" :lang="isEn ? 'en' : 'ar'" :dir="isEn ? 'ltr' : 'rtl'">
        <header class="grid self-start">
            <AppHeader />
        </header>

        <main class="grid items-center self-center p-5 h-[50vh] w-[50vw] it-ce mx-auto">
            <div class="text-3xl">Coming Soon</div>
        </main>

        <footer class="grid self-end">
            <AppFooter />
        </footer>
    </div>
</template>
