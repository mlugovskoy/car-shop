<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    count: Number,
    total: Number
})


</script>

<template>
    <div class="flex gap-2 text-gray-500 my-4">
        <span>Итого:</span>
        <div class="border-b border-dashed border-gray-200 flex-1"></div>
        <b>{{ total }} ₽</b>
    </div>

    <PrimaryButton :href="route('order')" tag="a" :disabled="count <= 0" class="w-full block text-center">Оформить
        заказ
    </PrimaryButton>
</template>
