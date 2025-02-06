<script setup>

import PrimaryButton from "@/Components/UI/PrimaryButton.vue";

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

    <PrimaryButton :disabled="count <= 0" class="w-full">Оформить заказ</PrimaryButton>
</template>
