<script setup>
import { Head, Link , usePage } from '@inertiajs/vue3';
import { watchEffect , computed, ref } from 'vue';
let props = defineProps({});
let isEn = computed(() => usePage().props.isEn);
let year = new Date().getFullYear();
let footer = computed(() => usePage().props.isEn ? " Designed & Developed & Deployed By Ali Hussein © " + (year)
    : " تم التصميم والتطوير والاستضافة  بواسطة علي حسين © "  + (year));
</script>
<template>
    <div class="my-5"></div> 
    <div class="w-full bg-main min-h-[4rem] text-center text-white p-5 grid it-ce">
        {{ footer }}
    </div>
</template>