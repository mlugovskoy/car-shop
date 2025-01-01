<script setup>
const props = defineProps({'makers': Array})
</script>

<template>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        <a v-for="maker in makers" :href="route('transport.index') + '/' + maker.name"
           class="flex items-center gap-2 group">
            <img class="w-10 h-10 object-contain"
                 :src="maker.images[0].image_path"
                 :alt="maker.images[0].image_title">
            <span class="text-xl transition-all group-hover:text-emerald-400">{{ maker.name }}</span>
        </a>
    </div>
</template>
