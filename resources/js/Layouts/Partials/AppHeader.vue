<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref, watchEffect } from 'vue';
import AppNav from '@/Layouts/Partials/AppNav.vue';
let showNav = ref(true); 
let toggleShow = ()=> {showNav.value = !showNav.value;}
</script>
<template>
    <div class="w-full bg-main min-h-[6rem] grid grid-cols-2 items-center " >
        <div class="text-white justify-self-start text-3xl mx-5">
            <Link href="/">
                {{ $page.props.isEn ? "Library" : "مكتبة" }}
            </Link>
        </div>
        <button class="justify-self-end border-4 border-main hover:border-white grid it-ce rounded-full p-2 w-[3rem] h-[3rem] mx-5" @click="toggleShow()" >
            <img src="/app-assets/icons/bars.svg" alt="bars" width="20px" >
        </button>
    </div>
    <div class="" v-if="showNav">
        <AppNav  />
    </div>
    <div class="my-5"></div> 
</template>