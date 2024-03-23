<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { computed, watchEffect } from 'vue';
let currentLang = computed(() => usePage().props.lang );
let isAuthenticated = computed(() => usePage().props.auth.check);
let currentRouteName = computed(() => usePage().props.routeName);
let currentRouteUrl = computed(() => usePage().props.routeUrl);
let langRoute = computed(() => usePage().props.langRoute);
let props = defineProps({});
let showFlash = ref(false);
watchEffect(() => {
    if( usePage().props.flash.success ) { 
    showFlash.value = true; 
    setTimeout(() => showFlash.value = false, 3000);
}
})

let navClasses = '';
watchEffect(() => {
    
})
</script>
<template>
    <!-- main nav -->
    <div class="w-full py-4 grid grid-cols-2 sm:grid-cols-4  it-ce shadow-[0px_3px_6px_0px_rgb(0,0,0,0.1)] text-center">
        <Link :href="langRoute" class="nav-item" :preserve-scroll="true" :preserve-state="true" >{{ $page.props.isEn ? "عربي" : "English"  }}</Link>
        <Link :href="route('landing')" class="nav-item" :class="currentRouteName == 'landing' || currentRouteName == 'books.index' ? 'active' : ''" >{{ $page.props.isEn ? "All Books" : "كل الكتب" }}</Link>
        <Link :href="route('login')" class="nav-item" :class="currentRouteName == 'login' ? 'active' : ''" v-if="!isAuthenticated">{{ $page.props.isEn ? "Login" : "تسجيل الدخول"  }}</Link>
        <Link :href="route('register')" class="nav-item" :class="currentRouteName == 'register' ? 'active' : ''" v-if="!isAuthenticated">{{ $page.props.isEn ?  "Register" : "تسجيل جديد" }}</Link>
        <Link :href="route('profile.edit')" class="nav-item" :class="currentRouteName == 'profile.edit' ? 'active' : ''" v-if="isAuthenticated">{{ $page.props.isEn ? "Profile" : "الملف الشخصي"  }}</Link>
        <Link :href="route('logout')" method="post" as="button" class="nav-item" v-if="isAuthenticated">{{ $page.props.isEn ? "Logout" : "تسجيل الخروج"  }}</Link>
    </div>

    <!-- user nav -->
    <div class="w-full py-4 grid grid-cols-2 sm:grid-cols-4  it-ce shadow-[0px_3px_6px_0px_rgb(0,0,0,0.1)] text-center" v-if="$page.props.auth.check && $page.props.auth.isAdmin == false">
        <Link :href="route('orders.pending')" class="nav-item" :class="currentRouteName == 'orders.pending' ? 'active' : ''" >{{ $page.props.isEn ? "Your Pending Orders" : "طلباتك المعلقة" }}</Link>
        <Link :href="route('orders.rejected')" class="nav-item" :class="currentRouteName == 'orders.rejected' ? 'active' : ''" >{{ $page.props.isEn ? "Your Rejected Orders" : "طلباتك المرفوضة" }}</Link>
        <Link :href="route('orders.borrowed')" class="nav-item" :class="currentRouteName == 'orders.borrowed' ? 'active' : ''" >{{ $page.props.isEn ? "Borrowed Books" : "الكتب المستعارة" }}</Link>
        <Link :href="route('orders.reversed')" class="nav-item" :class="currentRouteName == 'orders.reversed' ? 'active' : ''" >{{ $page.props.isEn ? "Reversed Books" : "الكتب المرجوعة" }}</Link>
    </div>

    <!-- admin nav -->
    <div class="w-full py-4 grid grid-cols-2  it-ce shadow-[0px_3px_6px_0px_rgb(0,0,0,0.1)] text-center" v-if="$page.props.auth.check && $page.props.auth.isAdmin">
        <Link :href="route('books.create')" class="nav-item" :class="currentRouteName == 'books.create' ? 'active' : ''" >{{ $page.props.isEn ? "Add a Book" : "اضف كتابا" }}</Link>
        <Link :href="route('orders.index')" class="nav-item" :class="currentRouteName == 'orders.index' ? 'active' : ''" >{{ $page.props.isEn ? "Pending Orders" : "الطلبات المعلقة" }}</Link>
    </div>
    
    <div class="w-full py-4 grid it-ce bg-green-400 text-center" v-if="showFlash">
        {{ $page.props.flash.success }} 
    </div>

</template>

