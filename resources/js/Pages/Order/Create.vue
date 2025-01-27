<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";

const page = usePage();
</script>

<template>
    <Head title="Оформление заказа"/>

    <Main>
        <div class="mx-auto pt-12 max-w-7xl px-6 lg:px-8">
            <MainTitle :href="route('order.create')">Оформление заказа</MainTitle>
        </div>

        <div class="flex gap-12 mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white w-4/6 p-4 shadow sm:rounded-lg sm:p-8">
                test
            </div>
            <div class="bg-white w-2/6 p-4 shadow sm:rounded-lg sm:p-8">
                Заказ
            </div>
        </div>
    </Main>
</template>
