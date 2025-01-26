<script setup>

import DrawerItem from "@/Components/Drawer/DrawerItem.vue";

const props = defineProps({
    items: Array
})
</script>

<template>
    <div class="flex flex-col gap-4 overflow-y-auto" v-if="props.items.length > 0">
        <DrawerItem v-for="item in props.items" :item="item"/>
    </div>
    <div v-else class="text-center text-gray-500">Корзина пуста</div>
</template>
