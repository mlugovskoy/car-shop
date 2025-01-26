<script setup>
import {inject} from "vue";

const props = defineProps({
    item: {
        type: Object,
        default: []
    }
})

const addAndDeleteToCart = inject('addAndDeleteToCart');
</script>

<template>
    <div v-if="item"
         class="flex gap-4 items-center border border-slate-200 p-4 rounded-md" :key="item.id">
        <img v-if="item.images[0]" :src="item.images[0].image_path" :alt="item.title"
             class="w-16 h-16 object-cover rounded-md">

        <div class="flex flex-auto flex-col text-gray-500">
            <a :href="route('transport.show', {section: item.maker.name, id: item.id})"
               class="transition-all hover:text-emerald-400">{{ item.title }}</a>
            <div class="flex justify-between mt-2 items-center">
                <b class="text-sm">{{ item.price }}</b>
                <button @click="addAndDeleteToCart(item)" class="opacity-20 hover:opacity-100 transition">
                    <svg class="fill-red-400" xmlns="http://www.w3.org/2000/svg" height="24px"
                         viewBox="0 -960 960 960"
                         width="24px">
                        <path
                            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
