<script setup>
import Main from '@/Layouts/Main.vue';
import {Head, usePage} from '@inertiajs/vue3';
import MainTitle from "@/Components/UI/MainTitle.vue";
import Pagination from "@/Components/Pagination.vue";

const page = usePage();

const news = page.props.news;
</script>

<template>
    <Head title="Новости"/>

    <Main>
        <div class="py-6 sm:py-12">
            <div class="mx-auto max-w-7xl overflow-hidden bg-white shadow-sm mt-10 mb-14 p-6 lg:p-8 sm:rounded-lg">
                <MainTitle :href="route('home')">Новости</MainTitle>

                <div class="grid grid-cols-2 gap-4">
                    <a v-for="article in news.data" :href="route('news.show', article.id)" class="rounded shadow group">
                        <img class="w-full h-[300px] object-cover rounded-t transition-all group-hover:opacity-85"
                             :src="article.images[0].image_path"
                             :alt="article.images[0].image_title">
                        <div class="rounded-b p-4">
                            <h4 class="text-xl mb-2">{{ article.title }}</h4>
                            <div class="mb-4 text-gray-500">
                                {{ article.description.slice(0, 100) + '...' }}
                            </div>
                            <div class="flex justify-between">
                                <div class="flex gap-2">
                                    <svg class="fill-emerald-400" xmlns="http://www.w3.org/2000/svg" height="24px"
                                         viewBox="0 -960 960 960" width="24px">
                                        <path
                                            d="M80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/>
                                    </svg>
                                    <span>{{ article.comments.length }}</span>
                                </div>
                                <div>
                                    {{ article.published_at }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <Pagination :links="news.links"/>
            </div>
        </div>
    </Main>
</template>
