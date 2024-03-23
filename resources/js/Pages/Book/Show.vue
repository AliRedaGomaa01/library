<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, reactive, watch, watchEffect } from 'vue';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineOptions({
    layout: Layout,
});
let isEn = computed(() => usePage().props.isEn);
let props = defineProps({
    book:
    {
        type:Object,
        required:true,
        default: {}
    }
});
</script>
<template>
    <Head :title="isEn ? 'Book Show' : 'عرض كتاب'"/>
    <div class="container">
        <div class="my-shadow rounded-xl grid center-container w-full gap-5 p-5">
            <h3>
            {{ $page.props.isEn ? "Tags" : "السمات" }}
            </h3>
            <p class="px-10">
                <span v-for="tag in book['tags']" :key="tag.id">{{tag.name}} , </span>
            </p>
            <h3>
            {{ $page.props.isEn ? "ISBN" : "الرقم التسلسلي" }}
            </h3>
            <p class="px-10">{{  book.isbn }}</p>
            <h3>
            {{ $page.props.isEn ? "Title" : "العنوان" }}
            </h3>
            <p class="px-10">{{  $page.props.isEn ? (book.title)['en'] : (book.title)['ar'] }}</p>
            <h3>
            {{ $page.props.isEn ? "Description" : "الوصف" }}
            </h3>
            <p class="px-10">{{ $page.props.isEn ? (book.description)['en'] : (book.description)['ar']  }}</p>
            <h3>
            {{ $page.props.isEn ? "Previewing Url" : "رابط المعاينة" }}
            </h3>
            <p class="px-10"> <a :href="book.url" target="_blank">{{ book.url }}</a></p>
            <h3>
            {{ $page.props.isEn ? "Images" : "الصور" }}
            </h3>
            <div class="grid it-ce" v-for="image in book['images']" :key="image.id">
                <a :href="image.url" target="_blank">
                    <img :src="image.url" :alt="'book image' + image.id" class="max-h-[300px] max-w-[300px]">
                </a>
            </div>
        </div>
    </div>
</template>
<style>
</style>

