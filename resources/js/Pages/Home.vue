<script setup>
import Main from '@/Layouts/Main.vue';
import {Head} from '@inertiajs/vue3';
import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';
import {Navigation} from 'swiper/modules';
import {ref} from "vue";

const modules = ref([Navigation]);

</script>

<template>
    <Head title="Home"/>

    <Main>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-emerald-400 text-4xl">Продажа авто в России</h1>
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-4 my-6"
                >
                    <swiper
                        :slides-per-view="6"
                        :space-between="50"
                        :navigation="true"
                        :modules="modules"
                    >
                        <swiper-slide>Slide 1</swiper-slide>
                        <swiper-slide>Slide 2</swiper-slide>
                        <swiper-slide>Slide 3</swiper-slide>
                        <swiper-slide>Slide 3</swiper-slide>
                        <swiper-slide>Slide 3</swiper-slide>
                        <swiper-slide>Slide 3</swiper-slide>
                        <swiper-slide>Slide 3</swiper-slide>
                        <swiper-slide>Slide 3</swiper-slide>

                    </swiper>
                </div>
            </div>
        </div>
    </Main>
</template>
