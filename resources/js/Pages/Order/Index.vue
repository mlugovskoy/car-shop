<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";

const page = usePage();
</script>

<template>
    <Head title="История заказов"/>

    <Main>
        <div class="mx-auto pt-12 max-w-7xl px-6 mb-14 lg:px-8">
            <MainTitle :href="route('orders')">История заказов</MainTitle>


            <div class="flex gap-6 md:gap-12">
                <div class="bg-white w-full flex flex-col gap-4 p-4 shadow rounded-md sm:rounded-lg sm:p-8">
                    <div class="border border-gray-100 rounded-md p-4"
                         v-if="page.props.items && page.props.items.length > 0"
                         v-for="item in page.props.items">
                        <span class="inline-block text-xs mb-4 text-gray-500">Заказ № {{ item.id }}</span>
                        <div class="flex flex-wrap gap-8 md:gap-16 text-sm">
                            <div class="flex flex-col min-w-20 gap-2">
                                <p>Код</p>
                                <p class="text-xs text-gray-500">{{ item.code }}</p>
                            </div>
                            <div class="flex flex-col min-w-20 gap-2">
                                <p>Количество товаров</p>
                                <p class="text-xs text-gray-500">{{ item.quantity }}</p>
                            </div>
                            <div class="flex flex-col min-w-20 gap-2">
                                <p>Дата оформления</p>
                                <p class="text-xs text-gray-500">{{ item.created_at }}</p>
                            </div>
                            <div class="flex flex-col min-w-20 gap-2">
                                <p>Стоимость</p>
                                <p class="text-xs text-gray-500">{{ item.price }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex justify-center items-center h-full text-xl text-gray-500">
                        Список заказов пуст
                    </div>
                </div>
                <div class="bg-white w-1/3 flex self-start flex-col gap-4 p-4 shadow rounded-md sm:rounded-lg sm:p-8">
                    <h4 class="text-base md:text-xl">Общая стоимость заказов</h4>
                    <p class="mt-auto text-right text-3xl font-semibold">
                        {{ page.props.total ? page.props.total : '0 ₽' }}</p>
                </div>
            </div>
        </div>
    </Main>
</template>
