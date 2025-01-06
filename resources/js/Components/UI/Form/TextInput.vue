<script setup>
import {onMounted, ref} from 'vue';

const model = defineModel({
    type: String,
    required: true,
    placeholder: String,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <input
        class="w-full rounded-md text-gray-500 border-2 border-emerald-400 shadow-sm focus:border-emerald-400 text-sm placeholder-gray-100"
        v-model="model"
        ref="input"
    />
</template>
