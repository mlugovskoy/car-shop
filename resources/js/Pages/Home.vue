<script setup>
import Main from '@/Layouts/Main.vue';
import {Head} from '@inertiajs/vue3';
import MainSlider from "@/Components/MainSlider/MainSlider.vue";
import MainFilter from "@/Components/MainFilter/MainFilter.vue";
import MainReviews from "@/Components/MainReviews/MainReviews.vue";
import MainNews from "@/Components/MainNews/MainNews.vue";
import MainTitle from "@/Components/UI/MainTitle.vue";
</script>

<template>
    <Head title="Home"/>

    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <MainTitle :href="route('home')">Продажа авто в России</MainTitle>
            </div>
            <div
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
            >
                <MainSlider/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-10 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <MainTitle :href="route('home')">Поиск объявлений</MainTitle>
                <MainFilter class="mb-20"/>

                <MainTitle href="#">Отзывы автовладельцев</MainTitle>
                <MainReviews class="mb-20"/>

                <MainTitle href="#">Новости</MainTitle>
                <MainNews/>
            </div>
        </div>
    </Main>
</template>
