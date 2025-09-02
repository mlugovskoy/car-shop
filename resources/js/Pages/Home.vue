<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, usePage} from '@inertiajs/vue3';
import MainSlider from "@/Components/MainSlider/MainSlider.vue";
import MainFilter from "@/Components/MainFilter/MainFilter.vue";
import MainNews from "@/Components/MainNews/MainNews.vue";
import MainTitle from "@/Components/UI/MainTitle.vue";

const page = usePage();
</script>

<template>
    <Head title="Главная"/>

    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <MainTitle :href="route('home')">Продажа авто в России</MainTitle>
            </div>
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <MainSlider :transports="page.props.topSliderTransports"/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-10 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <MainTitle :href="route('transport.index')">Поиск объявлений</MainTitle>
                <MainFilter :makers="page.props.makers" class="mb-20"/>

                <MainTitle :href="route('news.index')">Новости</MainTitle>
                <MainNews :news="page.props.latestNews"/>
            </div>
        </div>
    </Main>
</template>
