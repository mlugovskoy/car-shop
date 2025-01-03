<script setup>
const props = defineProps({'reviews': Array})
</script>

<template>
    <div class="flex flex-wrap gap-4 justify-center sm:gap-y-4 sm:justify-between">
        <a v-for="review in reviews" href="#" class="rounded-md shadow group w-[220px]">
            <img class="w-full h-[220px] object-cover rounded-t-md transition-all group-hover:opacity-85"
                 :src="review.images[0].image_path"
                 :alt="review.images[0].image_title">
            <div class="rounded-b-md p-4">
                <h4 class="text-xl mb-2">{{ review.makerName + ' ' + review.modelName + ', ' + review.year }}</h4>
                <div class="flex justify-between">
                    <div class="flex gap-2">
                        <svg class="fill-emerald-400" xmlns="http://www.w3.org/2000/svg" height="24px"
                             viewBox="0 -960 960 960" width="24px">
                            <path
                                d="M80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/>
                        </svg>
                        <span>{{ review.comments.length }}</span>
                    </div>
                    <div>
                        {{ review.published_at }}
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>
