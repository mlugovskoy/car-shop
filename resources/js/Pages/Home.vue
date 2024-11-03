<script setup>
import Main from '@/Layouts/Main.vue';
import {Head} from '@inertiajs/vue3';
import Slider from "@/Components/Slider/Slider.vue";
</script>

<template>
    <Head title="Home"/>

    <Main>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-emerald-400 text-4xl">Продажа авто в России</h1>
            </div>
            <div
                class="overflow-hidden bg-white shadow-sm sm:rounded-lg my-6"
            >
                <Slider/>
            </div>
            <div>
            </div>
        </div>
    </Main>
</template>
