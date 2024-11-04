<script setup>
import Main from '@/Layouts/Main.vue';
import {Head} from '@inertiajs/vue3';
import MainSlider from "@/Components/MainSlider/MainSlider.vue";
import MainFilter from "@/Components/MainFilter/MainFilter.vue";
import MainReviews from "@/Components/MainReviews/MainReviews.vue";
</script>

<template>
    <Head title="Home"/>

    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <h2 class="text-emerald-400 text-3xl sm:text-4xl mb-4 sm:mb-8 inline-block border-b-2 border-transparent transition-all hover:border-emerald-400">
                    <a :href="route('home')">
                        Продажа авто в России
                    </a>
                </h2>
            </div>
            <div
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
            >
                <MainSlider/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-10 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <h2 class="text-emerald-400 text-3xl sm:text-4xl mb-4 sm:mb-8 inline-block border-b-2 border-transparent transition-all hover:border-emerald-400">
                    <a :href="route('home')">
                        Поиск объявлений
                    </a>
                </h2>
                <MainFilter class="mb-20"/>

                <h2 class="text-emerald-400 text-3xl sm:text-4xl mb-4 sm:mb-8 inline-block border-b-2 border-transparent transition-all hover:border-emerald-400">
                    <a href="#">
                        Отзывы автовладельцев
                    </a>
                </h2>

                <MainReviews/>
            </div>
        </div>
    </Main>
</template>
