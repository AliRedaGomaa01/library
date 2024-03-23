<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { watchEffect } from 'vue';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

let props = defineProps({
    tags: Object,
});
defineOptions({
    layout: Layout,
});
let isEn = computed(() => usePage().props.isEn);

let fileInput = ref(null);

let form = useForm({
    tags: [],
    titleAr: null,
    titleEn: null,
    descriptionAr:null,
    descriptionEn:null,
    author:null,
    isbn:null,
    pdfFile: null,
    images: [],
});

let getImages = (event) => {
    form.images = event.target.files;
}

let getPdf = (event) => {
    form.pdfFile = event.target.files[0];
}

let submit = (e) => {
    form.post(route('books.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            e.target.reset();
        }
    });
}

let tagForm = useForm({
    name: null,
});

let tagSubmit = (e) => {
    tagForm.post(route('tags.store'), {
        preserveScroll: true,
        onSuccess: () => {
            tagForm.reset();
            e.target.reset();
        }
    });
}


</script>
<template>
    <Head :title="isEn ? 'Add Book' : 'اضافة كتاب'"/>
    <!-- Add tag form -->
    <div class="container">
        <form @submit.prevent="tagSubmit">
            <div class="grid gap-5 m-5 p-5 my-shadow rounded-xl center-container">
                <!-- name -->
                <div class="grid gap-5">
                    <label for="name">{{ isEn ? "Name" : "الاسم" }}</label>
                    <input type="text" v-model="tagForm.name" id="name" class="" autocomplete="on" required >
                    <div class="text-red-600" v-if="tagForm.errors.name" >{{ tagForm.errors.name }}</div>
                </div>
                <PrimaryButton type="submit" class="justify-self-end">{{ isEn ? "Add" : "أضف" }}</PrimaryButton>
            </div>
        </form>
    </div>
    <!-- Add book form -->
    <div class="container">
        <form @submit.prevent="submit">
            <div class="grid gap-5 m-5 p-5 my-shadow rounded-xl center-container">
                <!-- tags -->
                <label for="tags">{{ isEn ? "Tags" : "العلامات" }}</label>
                <select name="tags" id="tags" class="text-center" v-model="form.tags" multiple>
                    <option v-for="(value , key) in props.tags" :key="value" :value="key" class="text-center">{{ value }}</option>
                </select>
                <div class="text-red-600" v-if="form.errors.tags" >{{ form.errors.tags }}</div>
                <!-- title EN -->
                <div class="grid gap-5">
                    <label for="titleEn">{{ isEn ? "English Title" : "العنوان بالانجليزي" }}</label>
                    <input type="text" v-model="form.titleEn" id="titleEn" class="" required autocomplete="on">
                    <div class="text-red-600" v-if="form.errors.titleEn" >{{ form.errors.titleEn }}</div>
                </div>
                <!-- title Ar -->
                <div class="grid gap-5">
                    <label for="titleAr">{{ isEn ? "Arabic title":"العنوان بالعربي" }}</label>
                    <input type="text" v-model="form.titleAr" id="titleAr" class="" required autocomplete="on">
                    <div class="text-red-600" v-if="form.errors.titleAr" >{{ form.errors.titleAr }}</div>
                </div>
                <!-- descriptionAr -->
                <div class="grid gap-5">
                    <label for="descriptionAr">{{ isEn ? "Arabic Description" : "الوصف بالعربي" }}</label>
                    <textarea v-model="form.descriptionAr" id="descriptionAr" class="" cols="30" rows="10" required autocomplete="on"></textarea>
                    <div class="text-red-600" v-if="form.errors.descriptionAr" >{{ form.errors.descriptionAr }}</div>
                </div>
                <!-- descriptionEn -->
                <div class="grid gap-5">
                    <label for="descriptionEn">{{ isEn ? "English Description" : "الوصف بالإنجليزي" }}</label>
                    <textarea v-model="form.descriptionEn" id="descriptionEn" class="" cols="30" rows="10" required autocomplete="on"></textarea>
                    <div class="text-red-600" v-if="form.errors.descriptionEn" >{{ form.errors.descriptionEn }}</div>
                </div>
                <!-- author -->
                <div class="grid gap-5">
                    <label for="author">{{ isEn ? "Author" : "المؤلف" }}</label>
                    <input type="text" v-model="form.author" id="author" class="" required autocomplete="on">
                    <div class="text-red-600" v-if="form.errors.author" >{{ form.errors.author }}</div>
                </div>
                <!-- isbn -->
                <div class="grid gap-5">
                    <label for="isbn">{{ isEn ? "ISBN" : "الرقم التسلسلي" }}</label>
                    <input type="number" min="0" v-model="form.isbn" id="isbn" class="" required autocomplete="on">
                    <div class="text-red-600" v-if="form.errors.isbn" >{{ form.errors.isbn }}</div>
                </div>
                <!-- images  -->
                <label for="images">{{ isEn ? "Images" : "الصور" }}</label>
                <input type="file" @change="getImages" id="images" ref="fileInput" multiple>
                <div class="text-red-600" v-if="form.errors.images" >{{ form.errors.images }}</div>
                <!-- pdfFile  -->
                <label for="pdfFile">{{ isEn ? "pdf File" : "ملف pdf" }}</label>
                <input type="file" @change="getPdf" id="pdfFile" ref="fileInput" multiple>
                <div class="text-red-600" v-if="form.errors.pdfFile" >{{ form.errors.pdfFile }}</div>
                <!-- submit -->
                <PrimaryButton type="submit" class="justify-self-end">{{ isEn ? "Add" : "أضف" }}</PrimaryButton>
            </div>
        </form>
    </div>

</template>
<style>
    input::file-selector-button { 
        @apply bg-main text-white
    }  
</style>
