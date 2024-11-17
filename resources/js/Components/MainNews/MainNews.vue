<script setup>
const props = defineProps({'news': Array})
</script>

<template>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a v-for="(article, key) in news" :href="route('news.show', article.id)" class="rounded shadow group"
           :class="{'lg:col-span-2': key < 2}">
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
</template>
