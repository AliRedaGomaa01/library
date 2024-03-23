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
    orders:
    {
        type:Object,
        required:true,
        default: {}
    }
});
</script>
<template>
    <Head :title="isEn ? 'Book Show' : 'عرض كتاب'"/>
    <div class="" v-for="order in orders"    :key="order.id" >
        <div class="container">
            <div class="my-shadow rounded-xl grid center-container w-full gap-5 p-5" >
                <h1 class="text-center">
                {{ $page.props.isEn ? "Order Data" : "معلومات الطلب" }}
                </h1>
                <h3>
                {{ $page.props.isEn ? "Order Type" : "نوع الطلب" }}
                </h3>
                <p class="px-10">{{  order.type }}</p>
                <h1 class="text-center">
                {{ $page.props.isEn ? "User Data" : "معلومات المستخدم" }}
                </h1>
                <h3>
                {{ $page.props.isEn ? "User Name" : "اسم المستخدم" }}
                </h3>
                <p class="px-10">{{  order.user.name }}</p>
                <h3>
                {{ $page.props.isEn ? "User Email" : "ايميل المستخدم" }}
                </h3>
                <p class="px-10">{{  order.user.email }}</p>
                <h1 class="text-center">
                {{ $page.props.isEn ? "Book Data" : "معلومات الكتاب" }}
                </h1>
                <h3>
                {{ $page.props.isEn ? "ISBN" : "الرقم التسلسلي" }}
                </h3>
                <p class="px-10">{{  order.book.isbn }}</p>
                <h3>
                {{ $page.props.isEn ? "Title" : "العنوان" }}
                </h3>
                <p class="px-10">{{  $page.props.isEn ? (order.book.title)['en'] : (order.book.title)['ar'] }}</p>
                <h3>
                {{ $page.props.isEn ? "Description" : "الوصف" }}
                </h3>
                <p class="px-10">{{ $page.props.isEn ? (order.book.description)['en'] : (order.book.description)['ar']  }}</p>
                <h3>
                {{ $page.props.isEn ? "Previewing Url" : "رابط المعاينة" }}
                </h3>
                <p class="px-10"> <a :href="order.book.url" target="_blank">{{ order.book.url }}</a></p>
                <h3>
                {{ $page.props.isEn ? "Images" : "الصور" }}
                </h3>
            </div>
        </div>
        <div class="container">
            <div class="my-shadow rounded-xl grid grid-cols-2 center-container w-full gap-5 p-5 my-5 " v-if="order.type == 'borrow'">
                <Link :href="route('orders.update',[order.id,'accepted'])" method="patch" class="justify-self-center" preserve-scroll>
                    <PrimaryButton class="">{{  $page.props.isEn ? "Accept" : "قبول"  }}</PrimaryButton>
                </Link>
                <Link :href="route('orders.update',[order.id,'rejected'])" method="patch" class="justify-self-center" preserve-scroll>
                    <PrimaryButton class="bg-red-600">{{  $page.props.isEn ? "Reject" : "رفض"  }}</PrimaryButton>
                </Link>
            </div>
            <div class="my-shadow rounded-xl grid grid-cols-1 center-container w-full gap-5 p-5 my-5 " v-if="order.type == 'reverse'">
                <Link :href="route('orders.update',[order.id,'accepted'])" method="patch" class="justify-self-center" preserve-scroll>
                    <PrimaryButton class="">{{  $page.props.isEn ? "Confirm" : "تأكيد"  }}</PrimaryButton>
                </Link>
            </div>
        </div>
    </div>
    <div class="" v-if="orders == false">
        <div class="container">
            <div class="my-shadow rounded-xl grid center-container w-full gap-5 p-5" >
                <h3 class="text-center">{{ isEn ? "No Pending Orders" : "لا توجد طلبات معلقة" }}</h3>
            </div>
        </div>
    </div>
</template>
<style>
</style>

