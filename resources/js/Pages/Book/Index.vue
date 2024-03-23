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
    books:
    {
        type:Object,
        required:true,
        default: {}
    }
});
let books = computed(() => props.books.data);
let pages = reactive({
    current: props.books.current_page,
    last: props.books.last_page,
    prev: props.books.prev_page_url,
    next: props.books.next_page_url,
});
let contentClasses = "p-10";
</script>
<template>
    <Head :title="isEn ? 'Books' : 'الكتب'"/>
    <div class="container grid gap-10 " v-if="books">
        <div class="my-shadow rounded-xl grid center-container w-full gap-5 p-5 it-ce" v-if="$page.props.auth.isAdmin">
            <Link :href="route('books.create')" ><PrimaryButton>{{ $page.props.isEn ? "Add New Book" : "اضافة كتاب جديد" }}</PrimaryButton></Link>
        </div>

        <div class="my-shadow rounded-xl grid center-container w-full gap-5 p-5 it-ce">
            <h3>
            {{ $page.props.isEn ? "The Books" : "الكتب" }}
            </h3>
        </div>

        <div class="my-shadow rounded-xl grid center-container w-full gap-5 p-5" v-for="book in books" :key="book.id">
            <h3>
            {{ $page.props.isEn ? "Tags" : "السمات" }}
            </h3>
            <div class="">
                <span v-for="tag in book['tags']" :key="tag.id">{{tag.name}} , </span>
            </div>
            <h3>
            {{ $page.props.isEn ? "ISBN" : "الرقم التسلسلي" }}
            </h3>
            <p>{{  book.isbn }}</p>
            <h3>
            {{ $page.props.isEn ? "Title" : "العنوان" }}
            </h3>
            <p>{{  $page.props.isEn ? (book.title)['en'] : (book.title)['ar'] }}</p>
            <h3>
            {{ $page.props.isEn ? "Description" : "الوصف" }}
            </h3>
            <p>{{ $page.props.isEn ? (book.description)['en'] : (book.description)['ar']  }}</p>
            <h3>
            {{ $page.props.isEn ? "Previewing Url" : "رابط المعاينة" }}
            </h3>
            <p> <a :href="book.url" target="_blank">{{ book.url }}</a></p>
            <Link :href="route('books.show',book.id)" class="my-5 justify-self-center">
                <PrimaryButton class="" >{{  $page.props.isEn ? "Show" : "اعرض"  }}</PrimaryButton>
            </Link>
        </div>
        <!-- buttons -->
        <div class="grid grid-cols-3 it-ce w-full my-10 " v-if="props.books.last_page !== 1">
            <Link :href="pages.prev" class="" preserve-scroll >
                <PrimaryButton v-if="pages.prev"> {{isEn ? 'Previous' : "السابق"}} </PrimaryButton>
            </Link>
            <p class="justify-self-center " >{{pages.current}} {{isEn ? 'of' : "من"}} {{pages.last}}</p >
            <Link :href="pages.next" class=""  preserve-scroll>
                <PrimaryButton class="{{ $nextBtnCond ? 'hidden' : '' }}" v-if="pages.next"> {{isEn ? 'Next' : "التالي"}} </PrimaryButton>
            </Link>
        </div>
    </div>
    <div class="container grid grid-cols-1 my-shadow p-5 rounded-xl it-ce" v-if="props.books.data == false">{{ $page.props.isEn ? "No books" : "لا كتب" }}</div>
</template>
<style>
</style>

