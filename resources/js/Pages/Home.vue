<script setup>
import Main from '@/Layouts/Main.vue';
import {Head} from '@inertiajs/vue3';
import MainSlider from "@/Components/MainSlider/MainSlider.vue";
import MainFilter from "@/Components/MainFilter/MainFilter.vue";
</script>

<template>
    <Head title="Home"/>

    <Main>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h2 class="text-emerald-400 text-4xl mb-8">Продажа авто в России</h2>
            </div>
            <div
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
            >
                <MainSlider/>
            </div>
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-10 mb-14 sm:p-6 lg:p-8 sm:rounded-lg">
                <h2 class="text-emerald-400 text-4xl mb-8">Поиск объявлений</h2>
                <MainFilter class="mb-20"/>

                <h2 class="text-emerald-400 text-4xl mb-8">Отзывы автовладельцев</h2>

                <MainReviews/>
            </div>
        </div>
    </Main>
</template>
